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
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id('id_inventaris');
            $table->unsignedBigInteger('id_logistik')->nullable();
            $table->string('nama_inventaris');
            $table->string('deskripsi');
            $table->integer('jumlah');
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
            $table->timestamps();
            
            $table->foreign('id_logistik')->references('id_logistik')->on('admin_logistik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }

};

