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
        
        Schema::create('kategori_inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->string('deskripsi_kategori')->nullable();
            $table->timestamps();
        });

        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_logistik')->nullable();
            $table->unsignedBigInteger('kategori_id');
            $table->string('gambar_inventaris')->nullable();
            $table->string('nama_inventaris');
            $table->string('deskripsi');
            $table->integer('jumlah');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia'])->default('Tersedia');
            $table->timestamps();
    
            $table->foreign('id_logistik')->references('id')->on('admin_logistik');
            $table->foreign('kategori_id')->references('id')->on('kategori_inventaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
        Schema::dropIfExists('kategori_inventaris');
    }

};

