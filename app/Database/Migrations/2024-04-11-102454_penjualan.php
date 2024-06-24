<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penjualan extends Migration{
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
            'faktur'       		=> [
                    'type'           => 'VARCHAR',
                    'constraint'     => '100',
                    'unique'            => true,
            ],
            'tanggal_faktur' => [
                'type' => 'DATE',
            ],
            'subtotal' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'pajak_persen' => [
                'type'           => 'INT',
                'null'       => TRUE,
            ],
            'pajak_total' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'diskon_persen' => [
                'type'           => 'INT',
                'null'       => TRUE,
            ],
            'diskon_total' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'total_harga' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('penjualan', TRUE);

        // detail barang masuk
        $this->forge->addField([
            'faktur' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'barang_kode' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false, // Add NOT NULL constraint here
            ],
            'harga_beli' => [
                'type' => 'DECIMAL',
                'constraint' => '10,0',
                'null' => false, // Add NOT NULL constraint here
            ],
            'harga_jual' => [
                'type' => 'DECIMAL',
                'constraint' => '10,0',
                'null' => false, // Add NOT NULL constraint here
            ],
            'jumlah' => [
                'type' => 'BIGINT',
                'constraint' => 11,
                'null' => false, // Add NOT NULL constraint here
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '20,0',
                'null' => false, // Add NOT NULL constraint here
            ],
        ]);
        $this->forge->createTable('detail_penjualan', TRUE);
        
    }

    public function down(){
        $this->forge->dropTable('penjualan');
        $this->forge->dropTable('detail_penjualan');
    }
}