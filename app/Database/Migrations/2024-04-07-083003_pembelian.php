<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pembelian extends Migration{
    public function up(){

        // Barang masuk
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
                'kwitansi'       		=> [
                    'type'           => 'VARCHAR',
                    'constraint'     => '100',
                    'null'            => true,
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
        $this->forge->createTable('pembelian', TRUE);

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
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'harga_jual' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'jumlah' => [
                'type' => 'BIGINT',
                'constraint' => 11,
                'null' => false, // Add NOT NULL constraint here
            ],
            'subtotal' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
        ]);
        $this->forge->createTable('detail_pembelian', TRUE);

    }

    public function down(){
        $this->forge->dropTable('pembelian');
        $this->forge->dropTable('detail_pembelian');
    }
}