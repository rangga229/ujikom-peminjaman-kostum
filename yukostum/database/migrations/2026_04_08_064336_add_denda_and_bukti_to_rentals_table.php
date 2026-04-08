<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Tambahkan laci untuk denda (angka) dan bukti_kembali (teks/nama file foto)
            $table->integer('denda')->default(0)->after('status');
            $table->string('bukti_kembali')->nullable()->after('denda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn(['denda', 'bukti_kembali']);
        });
    }
};
