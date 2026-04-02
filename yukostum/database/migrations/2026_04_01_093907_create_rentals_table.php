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
         Schema::create('rentals', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID Pelanggan yang menyewa
        $table->foreignId('costume_id')->constrained()->onDelete('cascade'); // ID Kostum yang disewa
        $table->date('borrow_date'); // Tanggal mulai pinjam
        $table->date('return_date'); // Tanggal harus kembali
        $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dikembalikan'])->default('pending');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
