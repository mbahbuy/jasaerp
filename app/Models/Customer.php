<?php 
namespace App\Models;

use CodeIgniter\Model;

class Customer extends Model{
    protected $table      = 'customer';
    protected $primaryKey     = 'id';
    protected $useTimestamps   = true;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $allowedFields  = [
        'nama', 'email', 'phone', 'nama_toko', 'alamat', 'alamat_toko', 'bank', 'no_rekening',
    ];
}