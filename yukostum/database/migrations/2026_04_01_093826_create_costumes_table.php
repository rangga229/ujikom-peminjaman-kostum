<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('costumes', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama Baju
        $table->string('material')->nullable(); // Bahan (Katun, dll)
        $table->string('size'); // Ukuran (S, M, L, XL)
        $table->string('color'); // Warna
        $table->string('origin')->nullable(); // Negara Asal
        $table->string('type'); // Tipe Baju (Cosplay, dll)
        $table->integer('stock'); // Stok
        $table->enum('condition', ['baik', 'diperbaiki', 'rusak'])->default('baik'); // Kondisi
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costumes');
    }
};
