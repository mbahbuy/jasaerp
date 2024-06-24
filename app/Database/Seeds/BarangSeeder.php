<?php 
namespace App\Database\Seeds;

use App\Models\{Barang, Gudang};
use CodeIgniter\Commands\Help;
use CodeIgniter\HTTP\HTTPClient;

class BarangSeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $barang = new Barang();
        $gudang = new Gudang();
        $client = service('curlrequest');
        $faker = \Faker\Factory::create('id_ID');
        helper('text');
        $response = $client->request('GET', 'https://fakestoreapi.com/products');
        // $response = $client->request('GET', 'https://api.escuelajs.co/api/v1/products');

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);

            foreach ($data as $i) {
                $item = [
                    'nama_barang' => $i['title'],
                    'harga_barang' => $faker->randomElement([
                        100000,
                        50000,
                        75000,
                        125000,
                        150000,
                        175000,
                        200000,
                        225000,
                        250000,
                        275000,
                        300000,
                    ]), // Generate a random price
                    'gambar_barang' => $i['image'],
                    'kategori_id'   => 1,
                    'gudang_id'   => 1,
                    'satuan_id'   => 31,
                    'status'   => 1,
                    'kode_barang' => $faker->ean13(), // Generate a random code
                ];

                // Insert data into your database table
                $barang->insert($item);
                $gudang->insert_stock_gudang($item['kode_barang'], 0);
            }
        } else {
            // Handle API request failure
            echo 'Failed to fetch data from API';
        }
    }
}