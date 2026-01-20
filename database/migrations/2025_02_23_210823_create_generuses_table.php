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
        Schema::create('ms_generus', function (Blueprint $table) {
            $table->id('ms_generus_id'); // Primary key
            $table->unsignedBigInteger('ms_kelompok_id'); // FK ke kelompok

            $table->string('nama_generus', 150);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->text('alamat')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Index untuk pencarian cepat
            $table->index('ms_kelompok_id');
            $table->index('nama_generus');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_generus');
    }
};
