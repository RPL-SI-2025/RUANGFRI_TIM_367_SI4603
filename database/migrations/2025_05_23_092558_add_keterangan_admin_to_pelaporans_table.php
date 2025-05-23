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
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('deskripsi'); // atau sesuaikan posisi
        });
    }

    public function down()
    {
        Schema::table('pelaporans', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};
