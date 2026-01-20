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
         Schema::create('ms_desa', function (Blueprint $table) {
            $table->id('ms_desa_id');          // Primary Key
            $table->string('nama_desa', 255);  // Nama desa
            $table->string('nama_masjid', 255)->nullable(); // Nama masjid (nullable)
            $table->text('alamat')->nullable();            // Alamat desa/masjid
            $table->text('deskripsi')->nullable();         // Deskripsi tambahan
            $table->timestamps();
            $table->softDeletes();              // Soft delete
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_desa');
    }
};
