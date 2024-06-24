<?php 
namespace App\Models;

use CodeIgniter\Model;
use SteeveDroz\CiSlug\Slugify;

class Gudang extends Model{
    protected $table      = 'gudang';
    protected $primaryKey = 'id_gudang';
    protected $allowedFields = ['parent_id', 'nama_gudang', 'slug', 'alamat', 'kapasitas', 'status'];// data index yg boleh di isi
    protected $useTimestamps   = true;
    protected $beforeInsert = ['setSlug'];
    protected $beforeUpdate = ['setSlug'];

    public function setSlug($data)
    {
        $slugify = new Slugify($this);
        $data = $slugify->addSlug($data, 'nama_gudang');
        return $data;
    }

    public function get_selected_gudang_id()
    {
        $row = $this->db->table('selected_gudang')->select('gudang_id')->where('status', true)->get()->getRowObject();
        return (int)$row->gudang_id;
    }

    public function set_selected_gudang($id)
    {
        $this->db->table('selected_gudang')->update(['status'   => false]);
        $this->db->table('selected_gudang')->insert([
            'gudang_id'     => (int)$id,
            'status'        => true,
            'tanggal'       => date('Y-m-d'),
        ]);
        return true;
    }

    public function get_gudang_with_selected()
    {
        $builder = $this->db->table('gudang g');
        $builder->select('g.*, MAX(sg.status) as selected, MAX(sg.tanggal) as tanggal_selected');
        $builder->join('selected_gudang sg', 'sg.gudang_id = g.id_gudang', 'left');
        $builder->groupBy('g.id_gudang, g.parent_id, g.nama_gudang, g.slug, g.alamat, g.kapasitas, g.status');
        $data = $builder->get()->getResultArray();
        return $data;
    }
    
    public function insert_stock_gudang($barang_kode, $stock)
    {
        $this->db->table('stock_gudang')->insert([
            'gudang_id'     => $this->get_selected_gudang_id(),
            'barang_kode'   => $barang_kode,
            'stock'          => $stock
        ]);
        return true;
    }

    public function delete_stock_gudang($barang_kode)
    {
        $this->db->table('stock_gudang')->delete(['barang_kode' => $barang_kode]);
        return true;
    }

    public function update_stock_gudang($barang_kode, $stock)
    {
        $ID = $this->db->table('stock_gudang')->select('id')->where('barang_kode', $barang_kode)->get()->getRowObject();

        $this->db->table('stock_gudang')->update(['stock' => $stock], ['id' => $ID->id]);
        return true;
    }

}