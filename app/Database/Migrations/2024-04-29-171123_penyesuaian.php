<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penyesuaian extends Migration{
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
            'nilai' => [
                'type'       => 'FLOAT',
                'constraint' => 12,
            ],
            'waktu' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'jumlah' => [
                'type'       => 'FLOAT',
                'constraint' => 12,
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
        $this->forge->createTable('penyesuaian');

        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'penyesuaian_id' => [
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
        $this->forge->createTable('penyesuaian_detail');
    }

    public function down(){
        $this->forge->dropTable('penyesuaian');
        $this->forge->dropTable('penyesuaian_detail');
    }
}