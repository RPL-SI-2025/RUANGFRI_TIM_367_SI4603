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
        
        $this->call([
            AdminLogistikSeeder::class,
            KategoriInventarisSeeder::class,
            InventarisSeeder::class,
            MahasiswaSeeder::class,
            PinjamInventarisSeeder::class, 
        ]);
    }
}