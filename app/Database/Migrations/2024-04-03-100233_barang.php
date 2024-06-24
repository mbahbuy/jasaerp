<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration{
    public function up(){

        // Uncomment below if want config
        $this->forge->addField([
        		'id_barang' => [
        				'type'           => 'INT',
        				'unsigned'       => TRUE,
        				'auto_increment' => TRUE
        		],
                'gudang_id' => [
                    'type'           => 'INT',
                    'unsigned'       => TRUE,
                ],
                'kode_barang' => [
                    'type'           => 'VARCHAR',
                    'constraint'     => '100',
                ],
        		'nama_barang'       		=> [
        				'type'           => 'VARCHAR',
        				'constraint'     => '100',
        		],
                'slug' => [
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'comment' => 'sub-judul barang',
                ],
                'kategori_id' =>[
                    'type' => 'INT',
                    'unsigned'       => TRUE,
                ],
                'gudang_id' =>[
                    'type' => 'INT',
                    'unsigned'       => TRUE,
                ],
                'satuan_id' =>[
                    'type' => 'INT',
                    'unsigned'       => TRUE,
                ],
                'harga_barang' =>[
                    'type' => 'FLOAT',
                    'default' => 0,
                ],
                'gambar_barang' =>[
                    'type'       => 'VARCHAR',
                    'constraint' => '100',
                    'null'       => true,
                ],
                'status' => [
                    'type'       => 'INT',
                    'default' => true,
                ],
                'created_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                    'comment' => 'waktu pembuatan',
                ],
                'updated_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                    'comment' => 'waktu pembuatan',
                ],
        ]);
        $this->forge->addKey('id_barang', TRUE);
        $this->forge->createTable('barang');
    }

    public function down(){
        $this->forge->dropTable('barang');
    }
}