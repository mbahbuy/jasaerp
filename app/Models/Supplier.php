<?php 
namespace App\Models;

use CodeIgniter\Model;

class Supplier extends Model{
    protected $table      = 'supplier';
    protected $primaryKey     = 'id';
    protected $useTimestamps   = true;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $allowedFields  = [
        'nama', 'email', 'phone', 'nama_toko', 'alamat_toko', 'bank', 'no_rekening',
    ];
}