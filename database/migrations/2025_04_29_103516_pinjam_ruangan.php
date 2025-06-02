<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pinjam_ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ruangan');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_selesai');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('tujuan_peminjaman');
            $table->string('file_scan', 255)->nullable();
            $table->integer('status')->default(0);   
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->foreign('id_ruangan')->references('id')->on('ruangan');
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pinjam_ruangan');
    }
};
