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
        //
        // Create the 'ruangan' table
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id('id_ruangan');
            $table->foreignId('id_logistik')->unique();
            $table->string('nama_ruangan')->unique();
            $table->integer('kapasitas');
            $table->string('fasilitas');
            $table->string('lokasi');
            $table->string('status')->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // Drop the 'ruangan' table
        Schema::dropIfExists('ruangan');
    }
};
