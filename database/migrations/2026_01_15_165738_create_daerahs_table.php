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
        Schema::create('ms_daerah', function (Blueprint $table) {
            $table->id('ms_daerah_id');

            $table->string('nama_daerah');
            $table->string('nama_masjid')->nullable();
            $table->text('alamat')->nullable();
            $table->string('peta')->nullable();
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ms_daerah');
    }
};
