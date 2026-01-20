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
        Schema::create('ms_absensi_kegiatan', function (Blueprint $table) {
            $table->id('ms_absensi_kegiatan_id'); // Primary key
            $table->unsignedBigInteger('ms_kegiatan_id'); // FK ke kegiatan/event
            $table->unsignedBigInteger('ms_generus_id');  // FK ke generus
            $table->timestamp('waktu_hadir')->nullable(); // Waktu presensi
            $table->enum('status_hadir', ['hadir', 'izin', 'alpha'])->default('hadir');
            $table->text('deskripsi')->nullable();       // Catatan tambahan
            $table->timestamps();
            $table->softDeletes();
            
            // Unique supaya 1 generus hanya bisa presensi 1x per kegiatan
            $table->unique(['ms_kegiatan_id', 'ms_generus_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_absensi_kegiatan');
    }
};
