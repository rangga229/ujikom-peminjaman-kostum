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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            // Mencatat ID User yang melakukan aksi (bisa kosong jika sistem yang melakukan otomatis)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // Jenis aksi: "Tambah Kostum", "Hapus User", dll
            $table->text('description')->nullable(); // Detail rincian aksinya
            $table->timestamps(); // Mencatat waktu kejadian secara presisi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
