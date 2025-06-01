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
        
        // Jalankan seeders secara berurutan
        $this->call([
            AdminLogistikSeeder::class,
            KategoriInventarisSeeder::class, // Add this line
            InventarisSeeder::class,
            MahasiswaSeeder::class
        ]);
    }
}