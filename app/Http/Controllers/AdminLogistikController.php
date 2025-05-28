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
use Illuminate\Support\Carbon;

class AdminLogistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function landing()
    {
        $totalRuangan = Ruangan::count();
        $totalInventaris = Inventaris::count();
        $ruanganTersedia = Ruangan::where('status', 'Tersedia')->count();
        $inventarisTersedia = Inventaris::where('status', 'Tersedia')->count();
        $ruangans = Ruangan::latest()->get();
        $inventaris = Inventaris::latest()->get();
        return view('landing', compact('totalRuangan', 'totalInventaris', 'ruanganTersedia', 'inventarisTersedia', 'ruangans', 'inventaris'));
    }


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
    'jumlah' => [], // for rooms
    'jumlah_inventaris' => [] // for inventory
    ];

    for ($i = 5; $i >= 0; $i--) {
        $bulan = Carbon::now()->subMonths($i)->format('F');
        $tanggal = Carbon::now()->subMonths($i);
        
        $grafik['bulan'][] = $bulan;
        $grafik['jumlah'][] = PinjamRuangan::whereMonth('created_at', $tanggal->month)->count();
        $grafik['jumlah_inventaris'][] = PinjamInventaris::whereMonth('created_at', $tanggal->month)->count();
    }

    
    $aktivitasTerbaru = collect([
        ...PinjamRuangan::latest()->take(3)->get()->map(fn($item) => (object)[
            'deskripsi' => "Peminjaman ruangan oleh {$item->mahasiswa->nama}",
            'created_at' => $item->created_at
        ]),
        ...LaporInventaris::latest()->take(2)->get()->map(fn($item) => (object)[
            'deskripsi' => "Laporan kerusakan inventaris oleh {$item->mahasiswa->nama}",
            'created_at' => $item->created_at
        ]),
    ])->sortByDesc('created_at')->take(5);




        $pendingPeminjaman = PinjamRuangan::where('status', 0)->count();
        // $newLaporan = LaporanRuangan::where('status', 0)->count();

        // Add these to your compact statement
        return view('admin.dashboard', compact(
            'totalRuangan',
            'ruanganTersedia',
            'ruanganTidakTersedia',
            'totalInventaris',
            'inventarisTersedia',
            'inventarisTidakTersedia',
            'grafik',
            'aktivitasTerbaru',
            'pendingPeminjaman', // Add this
            // 'newLaporan'        // And this
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
