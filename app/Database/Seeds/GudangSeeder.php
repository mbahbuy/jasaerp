<?php 
namespace App\Database\Seeds;

use App\Models\{Gudang};

class GudangSeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $gudang = new Gudang();
        $data = [
            'parent_id' => 0,
            'nama_gudang' => 'PT Sendiko Dawuh',
            'alamat'        => 'Jl Gajah mada V no.15 Lamongan.',
            'kapasitas'     => 1000000,
            'status'        => true
        ];

        $gudang->insert($data);

        $this->db->table('selected_gudang')->insert([
            'gudang_id' => $gudang->insertID(),
            'status'    => true,
            'tanggal'   => date('Y-m-d')
        ]);
    }
}