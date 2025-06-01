<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventaris;
use App\Models\KategoriInventaris;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InventarisSeeder extends Seeder
{
    public function run()
    {

        if (Schema::hasTable('admin_logistik')) {
            try {
                $admin = DB::table('admin_logistik')->first();
                $adminId = $admin ? $admin->id : null;
            } catch (\Exception $e) {
                $adminId = null;
            }
        } else {
            $adminId = null;
        }


        $kategoris = [
            ['nama_kategori' => 'Elektronik', 'deskripsi_kategori' => 'Peralatan elektronik seperti proyektor, laptop, speaker'],
            ['nama_kategori' => 'Furniture', 'deskripsi_kategori' => 'Perabotan seperti meja, kursi, lemari'],
            ['nama_kategori' => 'Alat Lab', 'deskripsi_kategori' => 'Peralatan laboratorium dan penelitian'],
            ['nama_kategori' => 'Olahraga', 'deskripsi_kategori' => 'Peralatan olahraga dan aktivitas fisik'],
            ['nama_kategori' => 'Lainnya', 'deskripsi_kategori' => 'Kategori inventaris lainnya']
        ];

        foreach ($kategoris as $kategori) {
            KategoriInventaris::firstOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']], 
                $kategori
            );
        }

        
        $elektronikId = KategoriInventaris::where('nama_kategori', 'Elektronik')->first()->id;
        $furnitureId = KategoriInventaris::where('nama_kategori', 'Furniture')->first()->id;
        $lainnyaId = KategoriInventaris::where('nama_kategori', 'Lainnya')->first()->id;
        
        $items = [
            [
                'nama_inventaris' => 'Proyektor',
                'kategori_id' => $elektronikId,
                'deskripsi' => 'Proyektor merk Epson',
                'jumlah' => 10,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Kursi Lipat',
                'kategori_id' => $furnitureId,
                'deskripsi' => 'Kursi lipat untuk acara',
                'jumlah' => 50,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Meja Portable',
                'kategori_id' => $furnitureId,
                'deskripsi' => 'Meja portable untuk acara',
                'jumlah' => 20,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Speaker Portable',
                'kategori_id' => $elektronikId,
                'deskripsi' => 'Speaker JBL portable dengan mic',
                'jumlah' => 5,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Laptop',
                'kategori_id' => $elektronikId,
                'deskripsi' => 'Laptop merk Dell untuk keperluan acara',
                'jumlah' => 8,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Whiteboard',
                'kategori_id' => $lainnyaId,
                'deskripsi' => 'Whiteboard untuk presentasi',
                'jumlah' => 15,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Kabel HDMI',
                'kategori_id' => $elektronikId,
                'deskripsi' => 'Kabel HDMI 2 meter',
                'jumlah' => 25,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ],
            [
                'nama_inventaris' => 'Extension Kabel',
                'kategori_id' => $elektronikId,
                'deskripsi' => 'Extension kabel 5 meter',
                'jumlah' => 30,
                'status' => 'Tersedia',
                'id_logistik' => $adminId
            ]
        ];

        foreach ($items as $item) {
            Inventaris::create($item);
        }
    }
}