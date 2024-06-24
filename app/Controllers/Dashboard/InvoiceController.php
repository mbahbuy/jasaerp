<?php 
namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\{Invoice,Pembelian,Penjualan,Barang,Supplier,Customer,Gudang};
use Config\Database;

class InvoiceController extends BaseController{
    protected $db,$pembelian,$penjualan,$invoice,$barang,$supplier,$customer,$gudang;

    public function __construct()
    {
        $this->pembelian = new Pembelian();
        $this->penjualan = new Penjualan();
        $this->invoice = new Invoice();
        $this->barang = new Barang();
        $this->supplier = new Supplier();
        $this->customer = new Customer();
        $this->gudang = new Gudang();
        $this->db = Database::connect();
        session();
    }

    public function print($faktur)
    {
        $subscriber = [];
        $produk = [];
        $data = [];
        $gudang = [];
    
        $invoice = $this->invoice->where('faktur', $faktur)->first();
        $user = $this->db->table('users')
            ->where('id', $invoice['user_id'])
            ->get()
            ->getResultArray();
    
        $prefix = substr($faktur, 0, 2);
        if (in_array($prefix, ["BL", "JL"])) {
            if ($prefix === "BL") { /* faktur pembelian */
                $data = $this->pembelian->where('faktur', $faktur)->first();
                $produk = $this->db->table('detail_pembelian dp')
                    ->select('dp.harga_beli AS harga, dp.jumlah, dp.subtotal, b.kode_barang, b.nama_barang')
                    ->join('barang b', 'b.kode_barang = dp.barang_kode', 'inner')
                    ->where('dp.faktur', $faktur)
                    ->get()
                    ->getResultArray();
                $subscriber = ['type' => 'Supplier','data' => $this->supplier->where('id', $invoice['subcriber_id'])->first()];
            } elseif ($prefix === "JL") { /* faktur penjualan */
                $data = $this->penjualan->where('faktur', $faktur)->first();
                $produk = $this->db->table('detail_penjualan dp')
                    ->select('dp.harga_jual AS harga, dp.jumlah, dp.subtotal, b.kode_barang, b.nama_barang')
                    ->join('barang b', 'b.kode_barang = dp.barang_kode', 'inner')
                    ->where('dp.faktur', $faktur)
                    ->get()
                    ->getResultArray();
                $subscriber = ['type' => 'Customer','data' => $this->customer->where('id', $invoice['subcriber_id'])->first()];
            }
            $gudang = $this->gudang->where('id_gudang', $data['gudang_id'])->first();
        }
    
        return view('dashboard/invoice/print', [
            'title' => 'Print Faktur ' . $faktur,
            'user' => $user,
            'invoice' => $invoice,
            'subscriber' => $subscriber,
            'produk' => $produk,
            'data' => $data,
            'gudang' => $gudang,
        ]);
    }
    

}