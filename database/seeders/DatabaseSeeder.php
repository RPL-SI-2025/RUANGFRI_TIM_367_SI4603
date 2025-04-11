<?php

namespace Database\Seeders;

use App\Models\AdminLogistik;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Buat user untuk testing
        // User::create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@example.com',
        //     'password' => bcrypt('password'),
        //     'role' => 'admin',
        // ]);

        // User::create([
        //     'name' => 'Mahasiswa User',
        //     'email' => 'mahasiswa@example.com',
        //     'password' => bcrypt('password'),
        //     'role' => 'mahasiswa',
        // ]);

        // Jalankan seeders secara berurutan
        $this->call([
            AdminLogistikSeeder::class,
            InventarisSeeder::class,
            MahasiswaSeeder::class
        ]);
    }
}