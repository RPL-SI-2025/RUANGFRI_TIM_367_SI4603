<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            'nim' => '123456789',
            'nama_mahasiswa' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('1234'), 
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}