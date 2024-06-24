<?php 
namespace App\Database\Seeds;

use App\Models\{Satuan};

class SatuanSeeder extends \CodeIgniter\Database\Seeder{
    public function run(){
        $satuan = new Satuan();
        $data = [
            'Kilogram (kg)',
            'Gram (g)',
            'Ons (ons)',
            'Miligram (mg)',
            'Ton (ton)',

            'Liter (L)',
            'Mililiter (mL)',
            'Centiliter (cL)',
            'Dekaliter (daL)',

            'Meter (m)',
            'Centimeter (cm)',
            'Milimeter (mm)',
            'Kilometer (km)',

            'Meter persegi (m²)',
            'Kilometer persegi (km²)',
            'Hektar (ha)',
            'Are (a)',

            'Detik (s)',
            'Menit (min)',
            'Jam (h)',
            'Hari (d)',
            'Minggu (wk)',
            'Bulan (bln)',
            'Tahun (yr)',

            'Buah (buah)',
            'Paket (pak)',
            'Lusin (lusin)',
            'Gross (grs)',
            'Kardus (kds)',
            'Dus (dus)',
            'Pieces (pcs)',
        ];
        
        foreach ($data as $v) {
            $satuan->insert(['gudang_id' => 1,'nama_satuan' => $v]);
        }
        
    }
}