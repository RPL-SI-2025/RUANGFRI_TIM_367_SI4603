<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('pelaporans', function (Blueprint $table) {
        $table->id('id_lapor_ruangan');
        $table->unsignedBigInteger('id_mahasiswa');
        $table->unsignedBigInteger('id_logistik');
        $table->unsignedBigInteger('id_ruangan');
        $table ->unsignedBigInteger('id_pinjam_ruangan')->nullable();
        $table->date('datetime');
        $table->string('foto_awal', 255)->nullable();
        $table->string('foto_akhir', 255)->nullable();
        $table->string('deskripsi', 255)->nullable();
        $table->string('oleh');
        $table->string('kepada');
        $table->timestamps();

        $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa');
        $table->foreign('id_logistik')->references('id')->on('admin_logistik');
        $table->foreign('id_ruangan')->references('id')->on('ruangan');
        $table->foreign('id_pinjam_ruangan')->references('id')->on('pinjam_ruangan');

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelaporans');
    }
};
