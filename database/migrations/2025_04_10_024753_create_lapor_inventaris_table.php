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
        Schema::create('lapor_inventaris', function (Blueprint $table) {
            $table->id('id_lapor_inventaris');
                $table->unsignedBigInteger('id_logistik');
                $table->unsignedBigInteger('id_mahasiswa');;
                $table->unsignedBigInteger('id_pinjam_inventaris');
                $table->date('datetime');
                $table->string('foto_awal');
                $table->string('foto_akhir');
                $table->string('deskripsi');

                $table->string('oleh');
                $table->string('kepada');

                $table->timestamps();
                $table->foreign('id_logistik')->references('id')->on('admin_logistik');
                $table->foreign('id_mahasiswa')->references('id')->on('mahasiswa');
                $table->foreign('id_pinjam_inventaris')->references('id')->on('pinjam_inventaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapor_inventaris');
    }
};
