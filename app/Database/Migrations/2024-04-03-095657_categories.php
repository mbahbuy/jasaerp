<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategori extends Migration{
    public function up(){

        // Uncomment below if want config
        $this->forge->addField([
            'id_kategori'          		=> [
                    'type'           => 'INT',
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE
            ],
            'gudang_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'nama_kategori'       		=> [
                    'type'           => 'VARCHAR',
                    'constraint'     => '15',
                    'unique'            => true
            ],
            'slug'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '15',
            ],
            'status'       		=> [
                'type'           => 'INT',
                'constraint'     => '1',
                'default'       => true,
                'comment'       => "(status kategori)\n1/true: kategori aktif\n0/false: kategori terhapus"
            ],
        ]);
        $this->forge->addKey('id_kategori', TRUE);
        $this->forge->createTable('categories');
    }

    public function down(){
        $this->forge->dropTable('categories');
    }
}