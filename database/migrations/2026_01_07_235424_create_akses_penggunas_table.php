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
        Schema::create('ms_akses_pengguna', function (Blueprint $table) {
            $table->id('ms_akses_pengguna_id'); // Primary key

            $table->unsignedBigInteger('ms_desa_id');      // FK ke ms_desa
            $table->unsignedBigInteger('ms_pengguna_id');  // FK ke ms_pengguna

            $table->timestamps();
            $table->softDeletes();

            // Unique supaya 1 user tidak bisa punya akses ganda ke desa yang sama
            $table->unique(['ms_desa_id', 'ms_pengguna_id']);

            // Index untuk pencarian cepat
            $table->index('ms_desa_id');
            $table->index('ms_pengguna_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_akses_pengguna');
    }
};
