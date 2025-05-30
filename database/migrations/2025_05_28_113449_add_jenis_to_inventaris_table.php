<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->enum('jenis', ['Elektronik', 'Furniture', 'Alat Lab', 'Lainnya'])
                  ->after('nama_inventaris')
                  ->default('Lainnya');
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });
    }
};