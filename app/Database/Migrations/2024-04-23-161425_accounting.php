<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Accounting extends Migration{
    public function up(){

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'gudang_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'  => true
            ],
            'bukti' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'status' => [
                'type'       => 'INT',
                'default' => true,
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
        $this->forge->createTable('accounting');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'accounting_id' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'category3_kode' => [
                'type'           => 'INT',
                'unsigned'       => true,

            ],
            'debit' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'kredit' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('accounting_detail');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode' => [
                'type'  => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'detail' => [
                'type'       => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('accounting_category1');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category1_kode' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'kode' => [
                'type'  => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'detail' => [
                'type'       => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('accounting_category2');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category1_kode' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'category2_kode' => [
                'type'           => 'INT',
                'unsigned'       => true,
            ],
            'kode' => [
                'type'  => 'INT',
                'unsigned' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'detail' => [
                'type'       => 'TEXT',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('accounting_category3');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type'          => 'INT',
                'constraint'    => 1,
                'null'          => false,
                'comment'       => '1:Awal periode, 2:Akhir periode'
            ],
            'tanggal' => [
                'type'  => 'DATE',
                'null' => false,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('accounting_periode');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'gudang_id' => [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'tanggal' => [
                'type'  => 'DATE',
                'null' => false,
            ],
            'category3_kode' => [
                'type'           => 'INT',
                'unsigned'       => true,

            ],
            'debit' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'kredit' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'  => true
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('arus_kas');

    }

    public function down(){
        $this->forge->dropTable('accounting');
        $this->forge->dropTable('accounting_detail');
        $this->forge->dropTable('accounting_category1');
        $this->forge->dropTable('accounting_category2');
        $this->forge->dropTable('accounting_category3');
        $this->forge->dropTable('accounting_periode');
        $this->forge->dropTable('arus_kas');
    }
}