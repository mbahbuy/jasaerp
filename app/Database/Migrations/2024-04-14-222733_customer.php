<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Customer extends Migration{
    public function up(){

        // Uncomment below if want config
        $this->forge->addField([
            'id'          		=> [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'gudang_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'nama'       		=> [
                    'type'           => 'VARCHAR',
                    'constraint'     => '100',
            ],
            'email'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'phone'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'alamat'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'nama_toko'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'alamat_toko'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'bank'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'no_rekening'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('customer');
    }

    public function down(){
        $this->forge->dropTable('customer');
    }
}