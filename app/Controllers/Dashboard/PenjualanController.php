<?php 
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\{Penjualan,Invoice,Barang,Accounting,Customer, Gudang};
use Config\Database;

class PenjualanController extends BaseController
{
    protected $db,$penjualan,$invoice,$barang,$accounting,$customer, $gudang;

    public function __construct()
    {
        $this->penjualan = new Penjualan();
        $this->customer = new Customer();
        $this->invoice = new Invoice();
        $this->barang = new Barang();
        $this->accounting = new Accounting();
        $this->gudang = new Gudang();
        $this->db = Database::connect();
        session();
    }

    public function index()
    {
        return view('dashboard/penjualan/list', [
            'title' => 'List Penjualan',
            'hal' => 'penjualan/index',
        ]);
    }

    public function form()
    {
        return view('dashboard/penjualan/form', [
            'title' => 'Form Penjualan',
            'hal' => 'penjualan/form',
        ]);
    }

    public function produkjson()
    {
        $data = $this->barang->get_barangs_with_stock();

        return response()->setJSON($data);
    }

    public function penjualanjson()
    {
        $data = $this->penjualan->get_all_data_penjualan();
        
        return $this->response->setJSON($data);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'customer' => 'required|is_not_unique[customer.id]',
            'tanggal_faktur' => 'required|max_length[225]',
            'faktur' => 'required|is_unique[penjualan.faktur]',
            'produk' => 'required|valid_json',
            'subtotal' => 'required',
            'total_harga' => 'required',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar berita.',
            'is_not_unique' => 'Data tidak terdaftar dalam database.',
            'valid_json' => '{field} bukanlah data JSON.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }

        // hitung total pajak
        $subtotal = (int)$this->request->getVar('subtotal');
        $pajak_persen = (int)$this->request->getVar('pajak_persen');
        $pajak_total = $subtotal * $pajak_persen / 100;

        // hitung total diskon
        $diskon_persen = (int)$this->request->getVar('diskon_persen');
        $diskon_total = $subtotal * $diskon_persen / 100;

        // Save data pembelian
        $faktur = $this->request->getVar('faktur');
        $this->penjualan->save([
            'gudang_id' => $this->penjualan->get_selected_gudang_id(),
            'faktur' => $faktur,
            'tanggal_faktur' => $this->request->getVar('tanggal_faktur'),
            'subtotal' => $subtotal,
            'pajak_persen' => $pajak_persen,
            'pajak_total' => $pajak_total,
            'diskon_persen' => $diskon_persen,
            'diskon_total' => $diskon_total,
            'total_harga' => $this->request->getVar('total_harga'),
        ]);

        // simpan data detail penjualan
        $detail_produk = json_decode($this->request->getVar('produk'), true);
        foreach ($detail_produk as $dp) {
            $this->db->table('detail_penjualan')->insert([
                'faktur' => $faktur,
                'barang_kode' => $dp['kode_produk'],
                'harga_jual' => $dp['harga_jual'],
                'jumlah' => $dp['jumlah'],
                'subtotal' => $dp['subtotal'],
            ]);
        }

        // simpan data invoice
        $this->invoice->save([
            'gudang_id' => $this->penjualan->get_selected_gudang_id(),
            'user_id'       => user_id(),
            'subcriber_id'  => $this->request->getVar('customer'),
            'faktur'        => $faktur,
            'detail_status' => $this->request->getVar('pembelian')??'cash',
        ]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Penjualan telah disimpan']);
    }

    public function approve($faktur)
    {
        // Validation rules
        $validationRules = [
            'produk' => 'required|valid_json',
        ];
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'valid_json' => '{field} bukanlah data JSON.',
        ];
    
        // Validate the input data
        if (!$this->validate($validationRules, $validationMessages)) {
            $validationErrors = implode(', ', $this->validator->getErrors());
            return $this->response->setJSON(['bg' => 'bg-danger', 'message' => $validationErrors]);
        }
    
        // Get the JSON input
        $produkJson = $this->request->getVar('produk');
        $produk = json_decode($produkJson, true);
    
        // Validate the JSON decoding
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->response->setJSON([
                'bg' => 'bg-danger',
                'message' => 'Invalid JSON data: ' . json_last_error_msg()
            ]);
        }
    
        // Ensure $produk is an array
        if (!is_array($produk)) {
            return $this->response->setJSON([
                'bg' => 'bg-danger',
                'message' => 'Invalid data received'
            ]);
        }
    
        // Begin transaction to ensure data consistency
        $this->db->transBegin();
    
        try {
            $existingData = $this->invoice->where('faktur', $faktur)->first();
            if (!$existingData) {
                throw new \Exception('Invoice not found');
            }
    
            // Update the status in the invoice table
            $updateResult = $this->invoice->update($existingData['id'], ['status' => 1]);
            if ($updateResult === false) {
                throw new \Exception('Failed to update the invoice status');
            }

            $dataPenjualan = $this->penjualan->where('faktur', $faktur)->first();
            $dataSubciber = $this->customer->find($existingData['subcriber_id']);
            // insert to accounting
            $formatedRupiah = 'Rp ' . number_format($dataPenjualan['total_harga'], 0, '', '.');
            $deskripsi = "penjualan kepada customer($dataSubciber[nama_toko]) dengan $existingData[detail_status] sebesar $formatedRupiah dan tercatat dalam faktur($faktur)";
            $this->accounting->insert([
                'gudang_id' => $this->penjualan->get_selected_gudang_id(),
                'tanggal' => date('Y-m-d'),
                'bukti' => $existingData['faktur'],
                'deskripsi' => $deskripsi,
                'status' => true,
            ]);
            $accountingID = $this->accounting->insertID();

            $accountingDetail = [
                [// debit/pendapatan
                    'accounting_id' => $accountingID,
                    'category3_kode'  => $existingData['detail_status'] == 'due' ? $this->accounting->get_kode_akun3_like('hutang') : $this->accounting->get_kode_akun3_like('penjualan'),
                    'debit'         => $dataPenjualan['total_harga'],
                    'kredit'        => 0,
                ],[// kredit/persediaan
                    'accounting_id' => $accountingID,
                    'category3_kode'  => $this->accounting->get_kode_akun3_like('kas'),
                    'debit'         => 0,
                    'kredit'        => $dataPenjualan['total_harga'],
                ]
            ];
            
            $this->db->table('accounting_detail')->insertBatch($accountingDetail);

            // input data arus kas
            $this->accounting->insert_arus_kas($dataPenjualan['tanggal_faktur'], $this->accounting->get_kode_akun3_like('kas'), $dataPenjualan['total_harga'], 0, $deskripsi);
    
            // Update stock_barang in barang table
            foreach ($produk as $p) {
                if (!isset($p['kode']) || !isset($p['kuantitas'])) {
                    throw new \Exception('Invalid product data');
                }

                $exBarang = $this->barang->get_barang_with_kode($p['kode']);
                if ($exBarang) {
                    // update stock to stock_gudang
                    $stocknew = (int)$exBarang['stock'] - (int)$p['kuantitas'];
                    $this->gudang->update_stock_gudang($p['kode'], $stocknew);
                }
            }
    
            // Commit the transaction
            $this->db->transCommit();
    
            return $this->response->setJSON([
                'bg' => 'bg-success',
                'message' => 'Transaksi berhasil didata!'
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            $this->db->transRollback();
    
            return $this->response->setJSON([
                'bg' => 'bg-danger',
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage()
            ]);
        }
    }
    

    public function delete($faktur)
    {
        // Retrieve the existing data using the faktur
        $existingData = $this->penjualan->where('faktur', $faktur)->first();
    
        // Check if the data exists
        if (!$existingData) {
            return $this->response->setJSON([
                'bg' => 'bg-danger', 
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }
    
        // Begin transaction to ensure data consistency
        $this->db->transBegin();
    
        try {
            // Delete the main pembelian record
            $this->penjualan->delete($existingData['id']);
    
            // Delete associated detail_pembelian records
            $this->db->table('detail_penjualan')->where('faktur', $faktur)->delete();
    
            // Delete associated invoice records
            $this->invoice->where('faktur', $faktur)->delete();
    
            // Commit the transaction
            $this->db->transCommit();
    
            return $this->response->setJSON([
                'bg' => 'bg-success', 
                'message' => 'Transaksi berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction if any exception occurs
            $this->db->transRollback();
    
            return $this->response->setJSON([
                'bg' => 'bg-danger', 
                'message' => 'Gagal menghapus transaksi: ' . $e->getMessage()
            ]);
        }
    }

}