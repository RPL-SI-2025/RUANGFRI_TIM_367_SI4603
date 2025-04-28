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
        Schema::create('jadwal_ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ruangan');

            $table->date('tanggal_pengajuan');
            $table->date('tanggal_selesai');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('file_scan', 255)->nullable();
            $table->integer('status')->default(0); // 0: Menunggu Persetujuan, 1: Disetujui, 2: Ditolak, 3: Selesai
            $table->timestamps();

            $table->foreign('id_ruangan')->references('id')->on('ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('jadwal_ruangan');
    }
};
