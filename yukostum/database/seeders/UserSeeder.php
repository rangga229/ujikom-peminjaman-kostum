<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Bos Admin',
        'email' => 'admin@yukostum.com',
        'password' => bcrypt('rahasia123'),
        'role' => 'admin'
        ]);

        User::create([
        'name' => 'Petugas Gudang',
        'email' => 'petugas@yukostum.com',
        'password' => bcrypt('rahasia123'),
        'role' => 'petugas'
        ]);

        User::create([
        'name' => 'Pelanggan',
        'email' => 'user@gmail.com',
        'password' => bcrypt('rahasia123'),
        'role' => 'pelanggan'
        ]);
    }
}
