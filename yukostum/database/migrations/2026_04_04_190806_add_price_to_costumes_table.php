<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('costumes', function (Blueprint $table) {
        // Kita gunakan integer agar mudah dihitung (misal: 50000)
        $table->integer('price')->default(0)->after('condition');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('costumes', function (Blueprint $table) {
            //
        });
    }
};
