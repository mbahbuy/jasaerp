<?php 
namespace App\Models;

use CodeIgniter\Model;
use SteeveDroz\CiSlug\Slugify;

class Satuan extends Model{
    protected $table      = 'satuan';
    protected $primaryKey = 'id_satuan';
    protected $allowedFields = ['nama_satuan', 'slug', 'status'];// data index yg boleh di isi
    protected $beforeInsert = ['setSlug'];
    protected $beforeUpdate = ['setSlug'];

    public function setSlug($data)
    {
        $slugify = new Slugify($this);
        $data = $slugify->addSlug($data, 'nama_satuan');
        return $data;
    }

}