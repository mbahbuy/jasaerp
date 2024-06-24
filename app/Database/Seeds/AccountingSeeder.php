<?php 
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AccountingSeeder extends Seeder
{
    public function run()
    {
        $dataCategory1 = [
            ['name' => 'Aktiva', 'kode' => '1000'],
            ['name' => 'Kewajiban', 'kode' => '2000'],
            ['name' => 'Modal', 'kode' => '3000'],
            ['name' => 'Pendapatan', 'kode' => '4000'],
            ['name' => 'Beban', 'kode' => '5000'],
        ];
        
        $kodeCategory1 = [];
        foreach ($dataCategory1 as $dc1) {
            $this->db->table('accounting_category1')->insert($dc1);
            $kodeCategory1[$dc1['name']] = $dc1['kode'];
        }
        
        $dataCategory2 = [
            // Aktiva
            ['category1_kode' => $kodeCategory1['Aktiva'], 'name' => 'Kas dan Setara Kas', 'kode' => '1100'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'name' => 'Aktiva Lancar', 'kode' => '1200'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'name' => 'Aktiva Tetap', 'kode' => '1300'],
            
            // Kewajiban
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'name' => 'Kewajiban Lancar', 'kode' => '2100'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'name' => 'Kewajiban Jangka Panjang', 'kode' => '2200'],
            
            // Modal
            ['category1_kode' => $kodeCategory1['Modal'], 'name' => 'Modal Pemilik', 'kode' => '3100'],
            
            // Pendapatan
            ['category1_kode' => $kodeCategory1['Pendapatan'], 'name' => 'Pendapatan Operasional', 'kode' => '4100'],
            ['category1_kode' => $kodeCategory1['Pendapatan'], 'name' => 'Pendapatan Non-Operasional', 'kode' => '4200'],
            
            // Beban
            ['category1_kode' => $kodeCategory1['Beban'], 'name' => 'Beban Operasional', 'kode' => '5100'],
            ['category1_kode' => $kodeCategory1['Beban'], 'name' => 'Beban Non-Operasional', 'kode' => '5200'],
        ];
        
        $kodeCategory2 = [];
        foreach ($dataCategory2 as $dc2) {
            $this->db->table('accounting_category2')->insert($dc2);
            $kodeCategory2[$dc2['name']] = $dc2['kode'];
        }

        $dataCategory3 = [
            // Kas dan Setara Kas
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Kas dan Setara Kas'], 'name' => 'Kas', 'kode' => '1101'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Kas dan Setara Kas'], 'name' => 'Bank', 'kode' => '1102'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Kas dan Setara Kas'], 'name' => 'Deposito Berjangka', 'kode' => '1103'],
            
            // Aktiva Lancar
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Lancar'], 'name' => 'Piutang Dagang', 'kode' => '1201'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Lancar'], 'name' => 'Piutang Lainnya', 'kode' => '1202'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Lancar'], 'name' => 'Persediaan Barang', 'kode' => '1203'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Lancar'], 'name' => 'Beban Dibayar Dimuka', 'kode' => '1204'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Lancar'], 'name' => 'Investasi Jangka Pendek', 'kode' => '1205'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Lancar'], 'name' => 'Piutang Pajak', 'kode' => '1206'],
            
            // Aktiva Tetap
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Tanah', 'kode' => '1301'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Bangunan', 'kode' => '1302'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Peralatan dan Mesin', 'kode' => '1303'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Kendaraan', 'kode' => '1304'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Akumulasi Penyusutan Bangunan', 'kode' => '1305'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Akumulasi Penyusutan Peralatan dan Mesin', 'kode' => '1306'],
            ['category1_kode' => $kodeCategory1['Aktiva'], 'category2_kode' => $kodeCategory2['Aktiva Tetap'], 'name' => 'Akumulasi Penyusutan Kendaraan', 'kode' => '1307'],
            
            // Kewajiban Lancar
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Utang Dagang', 'kode' => '2101'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Utang Lainnya', 'kode' => '2102'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Utang Pajak', 'kode' => '2103'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Beban Yang Masih Harus Dibayar', 'kode' => '2104'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Pendapatan Diterima Dimuka', 'kode' => '2105'],
            
            // Kewajiban Lancar
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Utang Dagang', 'kode' => '2101'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Utang Lainnya', 'kode' => '2102'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Utang Pajak', 'kode' => '2103'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Beban Yang Masih Harus Dibayar', 'kode' => '2104'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Lancar'], 'name' => 'Pendapatan Diterima Dimuka', 'kode' => '2105'],
            
            // Kewajiban Jangka Panjang
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Jangka Panjang'], 'name' => 'Pinjaman Bank', 'kode' => '2201'],
            ['category1_kode' => $kodeCategory1['Kewajiban'], 'category2_kode' => $kodeCategory2['Kewajiban Jangka Panjang'], 'name' => 'Obligasi', 'kode' => '2202'],
            
            // Modal Pemilik
            ['category1_kode' => $kodeCategory1['Modal'], 'category2_kode' => $kodeCategory2['Modal Pemilik'], 'name' => 'Saham Biasa', 'kode' => '3101'],
            ['category1_kode' => $kodeCategory1['Modal'], 'category2_kode' => $kodeCategory2['Modal Pemilik'], 'name' => 'Saham Preferen', 'kode' => '3102'],
            ['category1_kode' => $kodeCategory1['Modal'], 'category2_kode' => $kodeCategory2['Modal Pemilik'], 'name' => 'Tambahan Modal Disetor', 'kode' => '3103'],
            ['category1_kode' => $kodeCategory1['Modal'], 'category2_kode' => $kodeCategory2['Modal Pemilik'], 'name' => 'Laba Ditahan', 'kode' => '3104'],
            
            // Pendapatan Operasional
            ['category1_kode' => $kodeCategory1['Pendapatan'], 'category2_kode' => $kodeCategory2['Pendapatan Operasional'], 'name' => 'Penjualan Produk', 'kode' => '4101'],
            ['category1_kode' => $kodeCategory1['Pendapatan'], 'category2_kode' => $kodeCategory2['Pendapatan Operasional'], 'name' => 'Pendapatan Jasa', 'kode' => '4102'],
            
            // Pendapatan Non-Operasional
            ['category1_kode' => $kodeCategory1['Pendapatan'], 'category2_kode' => $kodeCategory2['Pendapatan Non-Operasional'], 'name' => 'Pendapatan Sewa', 'kode' => '4201'],
            ['category1_kode' => $kodeCategory1['Pendapatan'], 'category2_kode' => $kodeCategory2['Pendapatan Non-Operasional'], 'name' => 'Pendapatan Bunga', 'kode' => '4202'],
            
            // Beban Operasional
            ['category1_kode' => $kodeCategory1['Beban'], 'category2_kode' => $kodeCategory2['Beban Operasional'], 'name' => 'Harga Pokok Penjualan', 'kode' => '5101'],
            ['category1_kode' => $kodeCategory1['Beban'], 'category2_kode' => $kodeCategory2['Beban Operasional'], 'name' => 'Biaya Produksi', 'kode' => '5102'],
            ['category1_kode' => $kodeCategory1['Beban'], 'category2_kode' => $kodeCategory2['Beban Operasional'], 'name' => 'Biaya Gaji', 'kode' => '5103'],
            ['category1_kode' => $kodeCategory1['Beban'], 'category2_kode' => $kodeCategory2['Beban Operasional'], 'name' => 'Biaya Pemasaran', 'kode' => '5104'],
            
            // Beban Non-Operasional
            ['category1_kode' => $kodeCategory1['Beban'], 'category2_kode' => $kodeCategory2['Beban Non-Operasional'], 'name' => 'Biaya Bunga', 'kode' => '5201'],
            ['category1_kode' => $kodeCategory1['Beban'], 'category2_kode' => $kodeCategory2['Beban Non-Operasional'], 'name' => 'Biaya Pajak', 'kode' => '5202'],
        ];        
        
        $this->db->table('accounting_category3')->insertBatch($dataCategory3);


        $periode = [
            [
                'type'      => 1,
                'tanggal'   => '2024-1-1'
            ],[
                'type'      => 2,
                'tanggal'   => '2024-12-31'
            ],
        ];

        $this->db->table('accounting_periode')->insertBatch($periode);
        
    }
}
