<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('pinjam_ruangan', function (Blueprint $table) {
            $table->id('id_pinjam_ruangan');
            $table->unsignedBigInteger('id_ruangan');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_jadwal');
            $table->unsignedBigInteger('id_logistik');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('waktu_selesai');
            $table->time('waktu_mulai');
            $table->string('file_scan')->default(0); // 0: Menunggu Persetujuan, 1: Disetujui, 2: Ditolak, 3: Selesai
            $table->string('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('pinjam_ruangan');
    }
};
