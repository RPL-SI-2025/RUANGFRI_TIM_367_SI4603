<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamInventarisTable extends Migration
{
    public function up()
    {
        Schema::create('pinjam_inventaris', function (Blueprint $table) {
            $table->id('id_pimjam_inventaris');
            $table->unsignedBigInteger('id_inventaris');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_selesai');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('file_scan', 255)->nullable();
            $table->integer('status');
            $table->timestamps();
            
            $table->foreign('id_inventaris')->references('id_inventaris')->on('inventaris');
            $table->foreign('id_mahasiswa')->references('id_mahasiswa')->on('mahasiswa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pinjam_inventaris');
    }
}