<?php 
namespace App\Models;

use CodeIgniter\Model;
use SteeveDroz\CiSlug\Slugify;

class Barang extends Model{
    protected $table      = 'barang';
    protected $primaryKey = 'id_barang';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'kategori_id', 'gudang_id', 'satuan_id', 'slug', 'harga_barang', 'gambar_barang', 'status'];// data index yg boleh di isi
    protected $useTimestamps   = true;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $beforeInsert = ['setSlug'];
    protected $beforeUpdate = ['setSlug'];

    public function get_selected_gudang_id()
    {
        $row = $this->db->table('selected_gudang')->select('gudang_id')->where('status', true)->get()->getRowObject();
        return (int)$row->gudang_id;
    }

    public function setSlug($data)
    {
        $slugify = new Slugify($this);
        $data = $slugify->addSlug($data, 'nama_barang');
        return $data;
    }

    public function get_all_barang_with_stock()
    {
        $builder = $this->db->table('barang');
        $builder->select('barang.*, categories.nama_kategori, gudang.nama_gudang, stock_gudang.stock, satuan.nama_satuan');
        $builder->join('categories', 'barang.kategori_id = categories.id_kategori', 'left');
        $builder->join('stock_gudang', 'barang.kode_barang = stock_gudang.barang_kode', 'left');
        $builder->join('gudang', 'barang.gudang_id = gudang.id_gudang', 'left');
        $builder->join('satuan', 'barang.satuan_id = satuan.id_satuan', 'left');
        $builder->where('barang.gudang_id', $this->get_selected_gudang_id());
        $dataActive = $builder->where('barang.status', true)->get()->getResultArray();

        $dataDeleted = $builder->where('barang.status', false)->get()->getResultArray();

        $data = array_merge($dataActive, $dataDeleted);
        
        return $data;
    }

    public function get_barangs_with_stock()
    {
        $builder = $this->db->table('barang');
        $builder->select('barang.*, categories.nama_kategori, gudang.nama_gudang, stock_gudang.stock, satuan.nama_satuan');
        $builder->join('categories', 'barang.kategori_id = categories.id_kategori', 'left');
        $builder->join('stock_gudang', 'barang.kode_barang = stock_gudang.barang_kode', 'left');
        $builder->join('gudang', 'barang.gudang_id = gudang.id_gudang', 'left');
        $builder->join('satuan', 'barang.satuan_id = satuan.id_satuan', 'left');
        $builder->where('barang.gudang_id', $this->get_selected_gudang_id());
        $data = $builder->where('barang.status', true)->get()->getResultArray();
        
        return $data;
    }

    public function get_barang($slug)
    {
        $builder = $this->db->table('barang');
        $builder->select('barang.*, categories.nama_kategori, gudang.nama_gudang, stock_gudang.stock, satuan.nama_satuan');
        $builder->join('categories', 'barang.kategori_id = categories.id_kategori', 'left');
        $builder->join('stock_gudang', 'barang.kode_barang = stock_gudang.barang_kode', 'left');
        $builder->join('gudang', 'barang.gudang_id = gudang.id_gudang', 'left');
        $builder->join('satuan', 'barang.satuan_id = satuan.id_satuan', 'left');
        $builder->where('barang.slug', $slug);
        $data = $builder->get()->getRowArray();
        return $data;
    }

    public function get_barang_with_kode($kode)
    {
        $builder = $this->db->table('barang');
        $builder->select('barang.*, categories.nama_kategori, gudang.nama_gudang, stock_gudang.stock, satuan.nama_satuan');
        $builder->join('categories', 'barang.kategori_id = categories.id_kategori', 'left');
        $builder->join('stock_gudang', 'barang.kode_barang = stock_gudang.barang_kode', 'left');
        $builder->join('gudang', 'barang.gudang_id = gudang.id_gudang', 'left');
        $builder->join('satuan', 'barang.satuan_id = satuan.id_satuan', 'left');
        $builder->where('barang.kode_barang', $kode);
        $data = $builder->get()->getRowArray();
        return $data;
    }

}