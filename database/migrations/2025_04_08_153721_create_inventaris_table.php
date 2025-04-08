<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarisTable extends Migration
{
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_admin_logistik');
            $table->string('nama_inventaris');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah')->default(1);
            $table->boolean('tersedia')->default(true);
            $table->integer('status');
            $table->timestamps();
            $table->foreign('id_logistik')->references('id')->on('admin_logistik')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventaris');
    }
}