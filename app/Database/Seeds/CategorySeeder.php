<?php 
namespace App\Database\Seeds;

use App\Models\{Category};

class CategorySeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $kategori = new Category();

        $data = [
            'nama_kategori' => 'Pakaian'
        ];

        $kategori->insert($data);
    }
}