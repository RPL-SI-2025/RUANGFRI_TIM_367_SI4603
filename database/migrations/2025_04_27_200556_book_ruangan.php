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
        Schema::create('book_ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ruangan');
            $table->unsignedBigInteger('id_mahasiswa');
            $table->unsignedBigInteger('id_jdadwal');;
            $table->integer('status_book')->default(0); // 0: Menunggu Persetujuan, 1: Disetujui, 2: Ditolak, 3: Selesai            $table->timestamps();
            $table->date('expired_at')->nullable();
            $table->timestamps();

            $table->foreign('id_ruangan')->references('id')->on('ruangan');
            $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa');
            $table->foreign('id_jdadwal')->references('id')->on('jadwal_ruangan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('book_ruangan');
    }
};
