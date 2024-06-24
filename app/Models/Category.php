<?php 
namespace App\Models;

use CodeIgniter\Model;
use SteeveDroz\CiSlug\Slugify;

class Category extends Model{
    protected $table      = 'categories';
    protected $primaryKey = 'id_kategori';
    protected $allowedFields = ['nama_kategori', 'slug', 'status'];// data index yg boleh di isi
    protected $beforeInsert = ['setSlug'];
    protected $beforeUpdate = ['setSlug'];

    public function setSlug($data)
    {
        $slugify = new Slugify($this);
        $data = $slugify->addSlug($data, 'nama_kategori');
        return $data;
    }

}