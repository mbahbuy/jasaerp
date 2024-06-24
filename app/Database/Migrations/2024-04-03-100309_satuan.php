<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration{
    public function up(){

        // Uncomment below if want config
        $this->forge->addField([
            'id_satuan'          		=> [
                    'type'           => 'INT',
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE
            ],
            'gudang_id'          		=> [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'nama_satuan'       		=> [
                    'type'           => 'VARCHAR',
                    'constraint'     => '100',
            ],
            'slug'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'status'       		=> [
                'type'           => 'INT',
                'constraint'     => '1',
                'default'       => true,
                'comment'       => "(status satuan)\n1/true: satuan aktif\n0/false: satuan terhapus"
            ],
        ]);
        $this->forge->addKey('id_satuan', TRUE);
        $this->forge->createTable('satuan');
    }

    public function down(){
        $this->forge->dropTable('satuan');
    }
}