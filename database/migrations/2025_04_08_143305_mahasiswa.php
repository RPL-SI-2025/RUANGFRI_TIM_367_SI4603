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
        // Create the 'mahasiswa' table
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id("id_mahasiswa");
            $table->string('nim')->unique();
            $table->string('nama_mahasiswa');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        // Drop the 'mahasiswa' table
        Schema::dropIfExists('mahasiswa');
    }
};
