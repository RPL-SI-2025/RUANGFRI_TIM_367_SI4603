<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminLogistikSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin_logistik')->insert([
            'nama' => 'Admin Logistik',
            'email' => 'admin@logistik.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}