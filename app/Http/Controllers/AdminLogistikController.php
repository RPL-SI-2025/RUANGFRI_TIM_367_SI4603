<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use App\Models\Inventaris;
use App\Models\StatusPeminjaman;
use App\Models\LaporInventaris;
use App\Models\LaporanRuangan;

class AdminLogistikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $totalRuangan = Ruangan::count();
        $ruanganTersedia = Ruangan::where('status', 'Tersedia')->count();
        $ruanganTidakTersedia = Ruangan::where('status', 'Tidak Tersedia')->count();

        $totalInventaris = Inventaris::count();
        $inventarisTersedia = Inventaris::where('status', 'Tersedia')->count();
        $inventarisTidakTersedia = Inventaris::where('status', 'Tidak Tersedia')->count();



        // $jumlahApprovalPending = StatusPeminjaman::where('status_approval', 'menunggu')->count();
        // $jumlahLaporan = LaporInventaris::count() + LaporanRuangan::count();

        return view('admin.dashboard', compact(
            'totalRuangan',
            'ruanganTersedia',
            'ruanganTidakTersedia',
            'totalInventaris',
            'inventarisTersedia',
            'inventarisTidakTersedia',
            // 'jumlahApprovalPending',
            // 'jumlahLaporan'
        ));

        return view('admin.dashboard');






















        return view('admin.dashboard');
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
