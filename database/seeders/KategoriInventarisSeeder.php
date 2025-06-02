<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriInventaris;

class KategoriInventarisSeeder extends Seeder
{
    public function run()
    {
        $kategoris = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi_kategori' => 'Peralatan elektronik seperti proyektor, laptop, speaker'
            ],
            [
                'nama_kategori' => 'Furniture',
                'deskripsi_kategori' => 'Perabotan seperti meja, kursi, lemari'
            ],
            [
                'nama_kategori' => 'Alat Lab',
                'deskripsi_kategori' => 'Peralatan laboratorium dan penelitian'
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi_kategori' => 'Peralatan olahraga dan aktivitas fisik'
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi_kategori' => 'Kategori inventaris lainnya'
            ]
        ];

        foreach ($kategoris as $kategori) {
            KategoriInventaris::create($kategori);
        }
    }
}