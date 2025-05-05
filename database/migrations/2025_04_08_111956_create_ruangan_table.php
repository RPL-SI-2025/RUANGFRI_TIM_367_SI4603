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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruangan');
            $table->integer('kapasitas');
            $table->text('fasilitas');
            $table->string('lokasi');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('id'); 
            $table->timestamps();
        
            // Foreign key
            $table->foreign('id_logistik')->references('id')->on('admin_logistik');
        });
        
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
