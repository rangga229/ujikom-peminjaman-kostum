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
            'type' => 'Cosplay Anime',
            'size' => 'M',
            'color' => 'Pink & Hitam',
            'material' => 'Polyester',
            'stock' => 3,
            'condition' => 'Baik',
            'price' => 50000
        ]);

        Costume::create([
            'name' => 'Baju Adat Jawa (Beskap Pria)',
            'images' => [], 
            'type' => 'Baju Adat',
            'size' => 'L',
            'color' => 'Hitam',
            'material' => 'Beludru',
            'stock' => 5,
            'condition' => 'Baik',
            'price' => 75000
        ]);

        Costume::create([
            'name' => 'Gaun Pesta Mewah (Eropa)',
            'images' => [], 
            'type' => 'Pakaian Formal',
            'size' => 'S',
            'color' => 'Merah Maroon',
            'material' => 'Sutra & Brokat',
            'stock' => 2,
            'condition' => 'Baik',
            'price' => 120000
        ]);
    }
}