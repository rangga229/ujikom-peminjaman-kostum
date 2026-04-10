<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Costume; 

class CostumeSeeder extends Seeder
{
    public function run()
    {
        Costume::create([
            'name' => 'Cosplay Nezuko Kamado',
            'images' => [], 
            'type' => 'Cosplay',
            'size' => 'M',
            'color' => 'Pink & Hitam',
            'material' => 'Polyester',
            'stock' => 3,
            'condition' => 'Baik',
            'price' => 50000
        ]);

        Costume::create([
            'name' => 'Jas Kelulusan Sekolah',
            'images' => [], 
            'type' => 'Acara Sekolah',
            'size' => 'L',
            'color' => 'Hitam',
            'material' => 'Beludru',
            'stock' => 5,
            'condition' => 'Baik',
            'price' => 75000
        ]);

        Costume::create([
            'name' => 'Gaun Pengantin Wanita',
            'images' => [], 
            'type' => 'Pernikahan',
            'size' => 'S',
            'color' => 'Merah Maroon',
            'material' => 'Sutra & Brokat',
            'stock' => 2,
            'condition' => 'Baik',
            'price' => 120000
        ]);

        Costume::create([
            'name' => 'Kebaya Tradisional',
            'images' => [], 
            'type' => 'Pentas Tari',
            'size' => 'S',
            'color' => 'Merah Maroon',
            'material' => 'Sutra & Brokat',
            'stock' => 2,
            'condition' => 'Baik',
            'price' => 120000
        ]);
    }
}