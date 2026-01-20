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
        Schema::create('ms_kegiatan', function (Blueprint $table) {
            $table->id('ms_kegiatan_id'); // Primary key

            $table->enum('scope', ['kelompok', 'desa', 'daerah'])->default('kelompok');

            $table->unsignedBigInteger('ms_kelompok_id')->nullable();
            $table->unsignedBigInteger('ms_desa_id')->nullable();

            $table->string('nama_kegiatan', 150);
            $table->string('tempat', 255)->nullable();
            $table->date('tanggal');
            $table->time('waktu')->nullable();

            $table->string('token_presensi', 100)->unique();
            $table->enum('status', ['draft', 'aktif', 'selesai'])->default('draft');
            $table->text('deskripsi')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk pencarian cepat
            $table->index('scope');
            $table->index('ms_kelompok_id');
            $table->index('ms_desa_id');
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_kegiatan');
    }
};
