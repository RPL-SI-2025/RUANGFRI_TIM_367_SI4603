<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_admin_logistik');
            $table->string('nama_inventaris');
            $table->text('deskripsi'); 
            $table->integer('jumlah'); 
            $table->boolean('tersedia')->default(true); 
            $table->enum('status', ['Tersedia', 'Tidak Tersedia']);
            $table->timestamps();
            
            $table->foreign('id_admin_logistik')->references('id')->on('admin_logistik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};