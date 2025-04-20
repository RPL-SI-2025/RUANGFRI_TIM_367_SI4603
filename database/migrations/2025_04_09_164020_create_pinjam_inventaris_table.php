<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamInventarisTable extends Migration
{
    public function up()
    {
        Schema::create('pinjam_inventaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_inventaris');
            $table->integer('jumlah_pinjam')->default(1); 
            $table->unsignedBigInteger('id_mahasiswa');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_selesai');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('file_scan', 255)->nullable();
            $table->integer('status')->default(0); // 0: Menunggu Persetujuan, 1: Disetujui, 2: Ditolak, 3: Selesai
            $table->timestamps();
            
            $table->foreign('id_inventaris')->references('id')->on('inventaris');
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pinjam_inventaris'); 
    }
}