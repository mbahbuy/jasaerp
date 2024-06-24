<?php 
namespace App\Models;

use CodeIgniter\Model;

class Penjualan extends Model{
    protected $table      = 'penjualan';
    protected $primaryKey     = 'id';
    protected $useTimestamps   = false;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $allowedFields  = [
        'gudang_id','faktur', 'tanggal_faktur', 'subtotal', 'pajak_persen', 'pajak_total', 'diskon_persen', 'diskon_total', 'total_harga', 
    ];

    public function get_selected_gudang_id()
    {
        $row = $this->db->table('selected_gudang')->select('gudang_id')->where('status', true)->get()->getRowObject();
        return (int)$row->gudang_id;
    }

    public function get_all_data_penjualan()
    {
        $data = $this->db->table('penjualan p')
            ->select('p.faktur, p.tanggal_faktur, p.subtotal, p.pajak_persen, p.pajak_total, p.diskon_persen, p.diskon_total, p.total_harga, u.name AS user, c.nama AS customer, c.email AS email_customer, c.phone AS phone_customer, c.bank AS bank_customer, c.no_rekening AS rekening_customer, c.nama_toko AS toko_customer, c.alamat_toko AS alamat_toko_customer, g.nama_gudang AS gudang, i.status, i.detail_status, i.note, i.bukti')
            ->join('gudang g', 'g.id_gudang=p.gudang_id', 'left')
            ->join('invoice i', 'i.faktur=p.faktur', 'inner')
            ->join('customer c', 'c.id=i.subcriber_id', 'left')
            ->join('users u', 'u.id=i.user_id', 'left')
            ->where('p.gudang_id', $this->get_selected_gudang_id())
            ->orderBy('p.id', 'DESC')
            ->get()->getResultArray();
    
        if (!empty($data)) {
            for ($i=0; $i < count($data); $i++) {
                $dataDetailPembelian = $this->db->table('detail_penjualan dp')
                    ->select('dp.harga_beli, dp.harga_jual, dp.jumlah, dp.subtotal, b.kode_barang, b.nama_barang, sg.stock')
                    ->join('barang b', 'b.kode_barang = dp.barang_kode')
                    ->join('stock_gudang sg', "sg.barang_kode = dp.barang_kode")
                    ->where('dp.faktur', $data[$i]['faktur'])
                    ->get()->getResultArray();
                $data[$i]['detail'] = $dataDetailPembelian;
            }
        }

        return $data;
    }
}