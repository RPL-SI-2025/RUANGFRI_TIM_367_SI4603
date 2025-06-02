<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Inventaris;
use App\Models\StatusPeminjaman;
use App\Models\LaporInventaris;
use App\Models\LaporanRuangan;
use App\Models\PinjamRuangan;
use App\Models\PinjamInventaris;
use App\Models\LaporRuangan;
use App\Models\Pelaporan;
use Illuminate\Support\Carbon;

class AdminLogistikController extends Controller
{
    
    public function index()
    {

        $totalRuangan = Ruangan::count();
        $ruanganTersedia = Ruangan::where('status', 'Tersedia')->count();
        $ruanganTidakTersedia = Ruangan::where('status', 'Tidak Tersedia')->count();

        $totalInventaris = Inventaris::count();
        $inventarisTersedia = Inventaris::where('status', 'Tersedia')->count();
        $inventarisTidakTersedia = Inventaris::where('status', 'Tidak Tersedia')->count();


        $grafik = [
            'bulan' => [],
            'jumlah' => [],
            'jumlah_inventaris' => []
        ];


        for ($i = 5; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i)->format('M Y');
            $tanggal = Carbon::now()->subMonths($i);
            
            $grafik['bulan'][] = $bulan;


            $ruanganBorrowings = PinjamRuangan::whereMonth('created_at', $tanggal->month)
                                    ->whereYear('created_at', $tanggal->year)
                                    ->get()
                                    ->groupBy(function($item) {
                                        return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                                                $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
                                    });
            $ruanganCount = $ruanganBorrowings->count();


            $inventarisBorrowings = PinjamInventaris::whereMonth('created_at', $tanggal->month)
                                            ->whereYear('created_at', $tanggal->year)
                                            ->get()
                                            ->groupBy(function($item) {
                                                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                                                        $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
                                            });
            $inventarisCount = $inventarisBorrowings->count();
            
            $grafik['jumlah'][] = $ruanganCount;
            $grafik['jumlah_inventaris'][] = $inventarisCount;
        }


        $aktivitasTerbaru = collect();

        $recentRoomBorrowings = PinjamRuangan::with('mahasiswa', 'ruangan')
            ->latest()
            ->take(50)   
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
            })
            ->take(3)   
            ->map(function($group) {
                $firstItem = $group->first();
                $roomNames = $group->pluck('ruangan.nama_ruangan')->filter()->implode(', ');
                $roomCount = $group->count();
                
                return (object)[
                    'deskripsi' => "Peminjaman " . ($roomCount > 1 ? "{$roomCount} ruangan" : "ruangan {$roomNames}") . " oleh " . ($firstItem->mahasiswa->nama_mahasiswa ?? 'Mahasiswa'),
                    'created_at' => $firstItem->created_at,
                    'type' => 'peminjaman_ruangan'
                ];
            });


        $recentInventoryBorrowings = PinjamInventaris::with('mahasiswa', 'inventaris')
            ->latest()
            ->take(50)   
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
            })
            ->take(2)   
            ->map(function($group) {
                $firstItem = $group->first();
                $inventoryNames = $group->pluck('inventaris.nama_inventaris')->filter();
                $inventoryCount = $group->count();
                
                if ($inventoryCount > 1) {
                    $description = "Peminjaman {$inventoryCount} inventaris oleh " . ($firstItem->mahasiswa->nama_mahasiswa ?? 'Mahasiswa');
                } else {
                    $description = "Peminjaman inventaris {$inventoryNames->first()} oleh " . ($firstItem->mahasiswa->nama_mahasiswa ?? 'Mahasiswa');
                }
                
                return (object)[
                    'deskripsi' => $description,
                    'created_at' => $firstItem->created_at,
                    'type' => 'peminjaman_inventaris'
                ];
            });


        $recentReports = LaporInventaris::with('mahasiswa')
            ->latest()
            ->take(2)
            ->get()
            ->map(function($item) {
                return (object)[
                    'deskripsi' => "Laporan inventaris oleh " . ($item->mahasiswa->nama_mahasiswa ?? 'Mahasiswa'),
                    'created_at' => $item->created_at,
                    'type' => 'laporan_inventaris'
                ];
            });


        $recentRoomReports = Pelaporan::with('mahasiswa')
            ->latest()
            ->take(2)
            ->get()
            ->map(function($item) {
                return (object)[
                    'deskripsi' => "Laporan ruangan oleh " . ($item->mahasiswa->nama_mahasiswa ?? 'Mahasiswa'),
                    'created_at' => $item->created_at,
                    'type' => 'laporan_ruangan'
                ];
            });


        $aktivitasTerbaru = $aktivitasTerbaru
            ->merge($recentRoomBorrowings)
            ->merge($recentInventoryBorrowings)
            ->merge($recentReports)
            ->merge($recentRoomReports)
            ->sortByDesc('created_at')
            ->take(5);

            
        $pendingRuanganBorrowings = PinjamRuangan::where('status', 0)
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
            });
        $pendingRuangan = $pendingRuanganBorrowings->count();
            
        $pendingInventarisBorrowings = PinjamInventaris::where('status', 0)
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
            });
        $pendingInventaris = $pendingInventarisBorrowings->count();
        
        $pendingPeminjaman = $pendingRuangan + $pendingInventaris;
        
        $newLaporan = LaporInventaris::whereDate('created_at', today())->count() +
                    Pelaporan::whereDate('created_at', today())->count();



                    
        return view('admin.dashboard', compact(
            'totalRuangan',
            'ruanganTersedia',
            'ruanganTidakTersedia',
            'totalInventaris',
            'inventarisTersedia',
            'inventarisTidakTersedia',
            'grafik',
            'aktivitasTerbaru',
            'pendingPeminjaman',
            'newLaporan'
        ));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }

    


}
