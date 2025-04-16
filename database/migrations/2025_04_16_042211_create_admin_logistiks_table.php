<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminLogistiksTable extends Migration
{
    public function up()
    {
        Schema::create('admin_logistik', function (Blueprint $table) {
            $table->id(); // primary key default
            $table->integer('id_logistik')->unique(); // field khusus
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin_logistik');
    }
}
