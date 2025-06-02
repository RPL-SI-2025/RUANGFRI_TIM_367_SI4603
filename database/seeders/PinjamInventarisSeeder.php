<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PinjamInventaris;
use App\Models\Mahasiswa;
use App\Models\Inventaris;
use Carbon\Carbon;

class PinjamInventarisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $mahasiswa = Mahasiswa::first();
        $inventaris = Inventaris::take(5)->get(); 
        
        if (!$mahasiswa || $inventaris->count() == 0) {
            $this->command->info('Tidak ada data mahasiswa atau inventaris. Pastikan MahasiswaSeeder dan InventarisSeeder sudah dijalankan.');
            return;
        }

        
        $peminjamanData = [
            [
                'tanggal_pengajuan' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'waktu_mulai' => '08:00:00',
                'waktu_selesai' => '16:00:00',
                'file_scan' => 'sample_scan_1.pdf',
                'inventaris_list' => [
                    ['id' => $inventaris[0]->id, 'jumlah' => 2],
                    ['id' => $inventaris[1]->id, 'jumlah' => 1],
                ]
            ],
            [
                'tanggal_pengajuan' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->addDays(4)->format('Y-m-d'),
                'waktu_mulai' => '09:00:00',
                'waktu_selesai' => '15:00:00',
                'file_scan' => 'sample_scan_2.pdf',
                'inventaris_list' => [
                    ['id' => $inventaris[2]->id, 'jumlah' => 3],
                ]
            ],
            [
                'tanggal_pengajuan' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'tanggal_selesai' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'waktu_mulai' => '10:00:00',
                'waktu_selesai' => '14:00:00',
                'file_scan' => 'sample_scan_3.pdf',
                'inventaris_list' => [
                    ['id' => $inventaris[3]->id, 'jumlah' => 1],
                    ['id' => $inventaris[4]->id, 'jumlah' => 2],
                ]
            ],
        ];

        foreach ($peminjamanData as $peminjaman) {
            foreach ($peminjaman['inventaris_list'] as $item) {
                $inventarisItem = Inventaris::find($item['id']);
                
                
                if ($inventarisItem && $inventarisItem->jumlah >= $item['jumlah']) {
                    PinjamInventaris::create([
                        'id_inventaris' => $item['id'],
                        'jumlah_pinjam' => $item['jumlah'],
                        'id_mahasiswa' => $mahasiswa->id,
                        'tanggal_pengajuan' => $peminjaman['tanggal_pengajuan'],
                        'tanggal_selesai' => $peminjaman['tanggal_selesai'],
                        'waktu_mulai' => $peminjaman['waktu_mulai'],
                        'waktu_selesai' => $peminjaman['waktu_selesai'],
                        'file_scan' => $peminjaman['file_scan'],
                        'status' => 0, 
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);

                    
                    $inventarisItem->jumlah -= $item['jumlah'];
                    
                    
                    if ($inventarisItem->jumlah <= 0) {
                        $inventarisItem->status = 'Tidak Tersedia';
                    }
                    
                    $inventarisItem->save();
                }
            }
        }

        $this->command->info('Seeder PinjamInventaris berhasil dijalankan dengan status menunggu persetujuan.');
    }
}