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
        Schema::create('ms_kelompok', function (Blueprint $table) {
            $table->id('ms_kelompok_id'); // Primary key
            $table->unsignedBigInteger('ms_desa_id'); // FK ke desa

            $table->string('nama_kelompok', 150);
            $table->string('nama_masjid', 150)->nullable();
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk pencarian cepat
            $table->index('ms_desa_id');
            $table->index('nama_kelompok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_kelompok');
    }
};
