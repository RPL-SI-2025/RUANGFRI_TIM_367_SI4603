<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventaris;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventarisSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah tabel admin_logistik ada dan berisi data
        if (Schema::hasTable('admin_logistik')) {
            try {
                $admin = DB::table('admin_logistik')->first();
                $adminId = $admin ? $admin->id_logistik : null;
            } catch (\Exception $e) {
                $adminId = null;
            }
        } else {
            $adminId = null;
        }
        
        $items = [
            [
                'nama_inventaris' => 'Proyektor',
                'deskripsi' => 'Proyektor merk Epson',
                'jumlah' => 10,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Kursi Lipat',
                'deskripsi' => 'Kursi lipat untuk acara',
                'jumlah' => 50,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Meja Portable',
                'deskripsi' => 'Meja portable untuk acara',
                'jumlah' => 20,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Speaker Portable',
                'deskripsi' => 'Speaker JBL portable dengan mic',
                'jumlah' => 5,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Laptop',
                'deskripsi' => 'Laptop merk Dell untuk keperluan acara',
                'jumlah' => 8,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ]
        ];

        foreach ($items as $item) {
            Inventaris::create($item);
        }
    }
}