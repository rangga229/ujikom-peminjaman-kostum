<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan perubahan ke database
     */
    public function up()
    {
        Schema::table('costumes', function (Blueprint $table) {
            // 1. Cek apakah kolom 'image' (lama) masih ada, jika ada maka hapus
            if (Schema::hasColumn('costumes', 'image')) {
                $table->dropColumn('image');
            }
            
            // 2. Cek apakah kolom 'images' (baru) belum ada, jika belum maka buatkan
            if (!Schema::hasColumn('costumes', 'images')) {
                $table->json('images')->nullable();
            }
        });
    }

    /**
     * Membatalkan perubahan (jika di-rollback)
     */
    public function down()
    {
        Schema::table('costumes', function (Blueprint $table) {
            if (Schema::hasColumn('costumes', 'images')) {
                $table->dropColumn('images');
            }
            if (!Schema::hasColumn('costumes', 'image')) {
                $table->string('image')->nullable();
            }
        });
    }
};