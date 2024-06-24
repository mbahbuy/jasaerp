<?php 
namespace App\Database\Seeds;
use App\Models\{Customer};

class CustomerSeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $customer = new Customer();
        $faker = \Faker\Factory::create('id_ID');
        for($i = 0; $i < 20; $i++)
        {
            $data = [
                'gudang_id' => 1,
                'nama' => $faker->name(),
                'alamat'    => $faker->address(),
                'email'    => $faker->email(),
                'phone'    => $faker->phoneNumber(),
                'nama_toko' => $faker->company(),
                'alamat_toko' => $faker->address(),
                'bank' => $faker->randomElement([
                    'Bank Central Asia (BCA)',
                    'Bank Mandiri',
                    'Bank Negara Indonesia (BNI)',
                    'Bank Rakyat Indonesia (BRI)',
                    'Bank Tabungan Negara (BTN)',
                    'Bank Danamon',
                    'Bank CIMB Niaga',
                    'Bank Permata',
                    'Bank Panin',
                    'Bank Mega',
                    'Bank Bukopin',
                    'Bank Sinarmas',
                    'Bank Maybank Indonesia',
                    'Bank OCBC NISP',
                    'Bank Commonwealth',
                    'Bank DBS Indonesia',
                    'Bank UOB Indonesia'
                ]),
                'no_rekening' => $faker->creditCardNumber('Visa', true),
            ];
            // Using Query Builder
            $customer->insert($data);
        }
    }
}