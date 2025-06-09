<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class adminSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('admin_logistik')->insert([
            'nama'       => 'Admin Logistik',
            'email'      => 'admin@logistik.com',
            'password'   => Hash::make('admin123'), // password hashed dengan bcrypt
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
