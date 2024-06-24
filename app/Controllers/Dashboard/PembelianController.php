<?php 
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\{Pembelian,Invoice,Barang, Accounting, Supplier, Gudang};
use Config\Database;

class PembelianController extends BaseController
{
    protected $db,$pembelian,$invoice,$barang, $accounting,$supplier, $gudang;

    public function __construct()
    {
        $this->pembelian = new Pembelian();
        $this->supplier = new Supplier();
        $this->invoice = new Invoice();
        $this->barang = new Barang();
        $this->accounting = new Accounting();
        $this->gudang = new Gudang();
        $this->db = Database::connect();
        session();
    }

    public function index()
    {
        return view('dashboard/pembelian/list', [
            'title' => 'List Pembelian',
            'hal' => 'pembelian/index',
        ]);
    }

    public function form()
    {
        return view('dashboard/pembelian/form', [
            'title' => 'Form Pembelian',
            'hal' => 'pembelian/form',
        ]);
    }

    public function produkjson()
    {
        $data = $this->barang->get_barangs_with_stock();

        return response()->setJSON($data);
    }

    public function pembelianjson()
    {
        $data = $this->pembelian->get_all_data_pembelian();
        
        return $this->response->setJSON($data);
    }

    public function store()
    {
        // Validation rules
        $validationRules = [
            'supplier' => 'required|is_not_unique[supplier.id]',
            'tanggal_faktur' => 'required|max_length[225]',
            'faktur' => 'required|is_unique[pembelian.faktur]',
            'produk' => 'required|valid_json',
            'subtotal' => 'required',
            'total_harga' => 'required',
        ];

        // Handle the uploaded bukti image
        $file = $this->request->getFile('bukti');
        $namaGambar = '';
        if ($file && !$file->getError() == 4) {
            $validationRules['bukti'] = 'uploaded[bukti]|is_image[bukti]|mime_in[bukti,image/jpg,image/jpeg,image/png,image/gif,image/svg]|max_size[bukti,2048]';
            $namaGambar = $file->getRandomName();
        }
    
        $validationMessages = [
            'required' => '{field} harus di isi.',
            'is_unique' => '{field} sudah ada dalam daftar berita.',
            'is_not_unique' => 'Data tidak terdaftar dalam database.',
            'valid_json' => '{field} bukanlah data JSON.',
            'uploaded' => 'File {field} wajib diunggah.',
            'is_image' => 'File {field} harus berupa gambar.',
            'mime_in' => 'File {field} harus memiliki tipe MIME yang valid: jpg, jpeg, png, gif, svg.',
            'max_size' => 'File {field} tidak boleh lebih dari {param} kilobyte.',
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

        // Save data pembelian
        $faktur = $this->request->getVar('faktur');
        $this->pembelian->save([
            'gudang_id' => $this->pembelian->get_selected_gudang_id(),
            'faktur' => $faktur,
            'kwitansi' => $this->request->getVar('kwitansi') ?? '',
            'tanggal_faktur' => $this->request->getVar('tanggal_faktur'),
            'subtotal' => $subtotal,
            'pajak_persen' => $pajak_persen,
            'pajak_total' => $pajak_total,
            'total_harga' => $this->request->getVar('total_harga'),
        ]);

        // simpan data detail pembelian
        $detail_produk = json_decode($this->request->getVar('produk'), true);
        foreach ($detail_produk as $dp) {
            $this->db->table('detail_pembelian')->insert([
                'faktur' => $faktur,
                'barang_kode' => $dp['kode_produk'],
                'harga_beli' => $dp['harga_beli'],
                'jumlah' => $dp['jumlah'],
                'subtotal' => $dp['subtotal'],
            ]);
        }

        if ($namaGambar !== '') {
            $file->move('images/bukti/', $namaGambar);
        }

        // simpan data invoice
        $this->invoice->save([
            'gudang_id'     => $this->pembelian->get_selected_gudang_id(),
            'user_id'       => user_id(),
            'subcriber_id'  => $this->request->getVar('supplier'),
            'faktur'        => $faktur,
            'detail_status' => $this->request->getVar('pembelian')??'cash',
            'bukti'         => $namaGambar,
        ]);

        return $this->response->setJSON(['bg' => 'bg-success', 'message' => 'Pembelian telah disimpan']);
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
        $produk = json_decode($this->request->getVar('produk'), true);

        // Validate the input
        if (!isset($produk)) {
            return $this->response->setJSON([
                'bg' => 'bg-danger',
                'message' => 'Invalid data received'
            ]);
        }

        // Begin transaction to ensure data consistency
        $this->db->transBegin();

        try {
            $existingData = $this->invoice->where('faktur', $faktur)->first();
            // Update the status in the invoice table
            $updateResult = $this->invoice->update($existingData['id'],['status' => 1]);

            if ($updateResult === false) {
                throw new \Exception('Failed to update the invoice status');
            }

            // insert to accounting
            $dataPembelian = $this->pembelian->where('faktur', $faktur)->first();
            $dataSubciber = $this->supplier->find($existingData['subcriber_id']);

            $formatedRupiah = 'Rp ' . number_format($dataPembelian['total_harga'], 0, '', '.');
            $deskripsi = "pembelian dari pemasok($dataSubciber[nama]/$dataSubciber[nama_toko]) dengan $existingData[detail_status] sebesar $formatedRupiah dan tercatat dalam faktur($faktur)";
            $this->accounting->insert([
                'gudang_id' => $this->pembelian->get_selected_gudang_id(),
                'tanggal' => $dataPembelian['tanggal_faktur'],
                'bukti' => $existingData['faktur'],
                'deskripsi' => $deskripsi,
                'status' => true,
            ]);
            $accountingID = $this->accounting->insertID();

            $accountingDetail = [
                [// debit/persediaan
                    'accounting_id' => $accountingID,
                    'category3_kode'  => 1130,
                    'debit'         => $dataPembelian['total_harga'],
                    'kredit'        => 0,
                ],[// kredit/kas
                    'accounting_id' => $accountingID,
                    'category3_kode'  => $existingData['detail_status'] == 'due' ? 2110 : 1110,
                    'debit'         => 0,
                    'kredit'        => $dataPembelian['total_harga'],
                ]
            ];
            
            $this->db->table('accounting_detail')->insertBatch($accountingDetail);

            // input data arus kas
            $this->accounting->insert_arus_kas($dataPembelian['tanggal_faktur'], 1130, 0, $dataPembelian['total_harga'], $deskripsi);

            // Update stock_barang in stock_gudang
            foreach ($produk as $p) {
                $exBarang = $this->barang->get_barang_with_kode($p['kode']);
                if ($exBarang) {
                    // update stock to stock_gudang
                    $stocknew = (int)$exBarang['stock'] + (int)$p['kuantitas'];
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
        $existingData = $this->pembelian->where('faktur', $faktur)->first();
    
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
            $this->pembelian->delete($existingData['id']);
    
            // Delete associated detail_pembelian records
            $this->db->table('detail_pembelian')->where('faktur', $faktur)->delete();
    
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