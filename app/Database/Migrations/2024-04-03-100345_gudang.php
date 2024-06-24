<?php 
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gudang extends Migration{
    public function up(){

        // Uncomment below if want config
        $this->forge->addField([
            'id_gudang'          		=> [
                    'type'           => 'INT',
                    'unsigned'       => TRUE,
                    'auto_increment' => TRUE
            ],
            'parent_id'          		=> [
                'type'           => 'INT',
                'unsigned'       => TRUE,
            ],
            'nama_gudang'       		=> [
                    'type'           => 'VARCHAR',
                    'constraint'     => '100',
            ],
            'slug'       		=> [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'alamat'       		=> [
                'type'           => 'text',
                'null'     => true,
            ],
            'kapasitas'         => [
                'type'          => 'INT',
                'default'       => 0
            ],
            'status'       		=> [
                'type'           => 'INT',
                'constraint'     => '1',
                'default'       => true,
                'comment'       => "(status gudang)\n1/true: gudang aktif\n0/false: gudang terhapus"
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
        $this->forge->addKey('id_gudang', TRUE);
        $this->forge->createTable('gudang');

        // Tabel Stok Gudang
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'gudang_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'barang_kode' => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
            ],
            'stock' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('stock_gudang');

        // Tabel Selected Gudang
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'gudang_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'status'       		=> [
                'type'           => 'INT',
                'constraint'     => '1',
                'default'       => true,
                'comment'       => "(status gudang)\n1/true: gudang aktif\n0/false: gudang terhapus"
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('selected_gudang');   
    }

    public function down(){
        $this->forge->dropTable('gudang');
        $this->forge->dropTable('stock_gudang');
        $this->forge->dropTable('selected_gudang');
    }
}