<?php 
namespace App\Models;

use CodeIgniter\Model;

class Invoice extends Model{
    protected $table      = 'invoice';
    protected $primaryKey     = 'id';
    protected $useTimestamps   = true;
    protected $useSoftDeletes = false; // Set to true if you're using soft deletes
    protected $allowedFields  = [
        'gudang_id','user_id', 'subcriber_id', 'faktur', 'status', 'detail_status', 'note', 'bukti', 
    ];
}