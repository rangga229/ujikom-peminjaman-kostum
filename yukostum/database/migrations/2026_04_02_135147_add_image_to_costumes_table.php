<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('costumes', function (Blueprint $table) {
            $table->dropColumn('image'); // Hapus kolom tunggal yang lama
            $table->json('images')->nullable(); // Buat kolom baru yang bisa menampung banyak foto
        });
    }

    public function down()
    {
        Schema::table('costumes', function (Blueprint $table) {
            $table->dropColumn('images');
            $table->string('image')->nullable();
        });
    }
};