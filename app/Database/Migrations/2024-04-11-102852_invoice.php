<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Invoice extends Migration{
    public function up(){

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'auto_increment' => TRUE
            ],
            'gudang_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'user_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'comment' => 'ID user',
            ],
            'subcriber_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
                'comment' => 'ID subcriber/customer/supplier',
            ],
            'faktur' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'comment' => 'kode faktur',
            ],
            'status' => [
                'type'    => 'INT',
                'default' => 0,
                'comment' => "status\n[0:Panding, 1:success, 2:Batal]",
            ],
            'detail_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => 'cash',
                'comment'    => "status\n[uang tunai:cash, transfer bank:tf, bayar tempo:due]",
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bukti' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->createTable('invoice', TRUE);
        
    }

    public function down(){
        $this->forge->dropTable('invoice');
    }
}