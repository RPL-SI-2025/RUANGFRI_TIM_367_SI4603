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
                $table->integer('id_logistik');
                $table->integer('id_mahasiswa')->unique();
                $table->date('datetime');
                $table->string('foto_awal');
                $table->string('foto_akhir');
                $table->string('deskripsi');
                $table->string('oleh');
                $table->string('kepada');
                $table->timestamps();
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
