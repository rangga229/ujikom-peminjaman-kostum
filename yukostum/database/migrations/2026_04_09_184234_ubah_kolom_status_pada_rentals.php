<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    public function up()
    {
        // Menggunakan perintah SQL mentah untuk mengubah kolom ENUM menjadi VARCHAR
        DB::statement("ALTER TABLE rentals MODIFY status VARCHAR(255) DEFAULT 'belum_bayar'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE rentals MODIFY status ENUM('pending', 'disetujui', 'dikembalikan', 'ditolak') DEFAULT 'pending'");
    }
};