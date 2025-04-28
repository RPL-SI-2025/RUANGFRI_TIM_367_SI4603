<?php

namespace App\Http\Controllers;

use App\Models\LaporInventaris;  // Menggunakan LaporInventaris dengan PascalCase
use App\Models\AdminLogistik;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

class laporinventarisController extends Controller
{
   
        public function index()
        {
            $mahasiswaId = Session::get('mahasiswa_id');
            
            if (!$mahasiswaId) {
                return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $laporan = LaporInventaris::with(['mahasiswa', 'logistik'])->get();
            return view('mahasiswa.pelaporan.lapor_inventaris.index', compact('laporan'));
        }

   
    public function create()
    {
        $logistiks = AdminLogistik::all(); // Ambil semua data Admin Logistik
        return view('mahasiswa.pelaporan.lapor_inventaris.create', compact('logistiks'));
    }


    public function edit($id)
    {
        $laporan = LaporInventaris::find($id);
        $logistiks = AdminLogistik::all(); // Sama, ambil semua Admin Logistik

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('mahasiswa.pelaporan.lapor_inventaris.edit', compact('laporan', 'logistiks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_logistik' => 'required|exists:admin_logistik,id',
            'id_mahasiswa' => 'required|exists:mahasiswa,id',
            'datetime' => 'required|date',
            'foto_awal' => 'required|image|mimes:png|max:2048',
            'foto_akhir' => 'required|image|mimes:png|max:2048',
            'deskripsi' => 'required|string',
            'oleh' => 'required|string',
            'kepada' => 'required|string',
        ]);

        // Simpan foto
        $fotoAwalPath = $request->file('foto_awal')->store('laporan/foto_awal', 'public');
        $fotoAkhirPath = $request->file('foto_akhir')->store('laporan/foto_akhir', 'public');

        // Simpan ke database
        LaporInventaris::create([
            'id_logistik' => $request->id_logistik,
            'id_mahasiswa' => $request->id_mahasiswa,
            'datetime' => $request->datetime,
            'foto_awal' => $fotoAwalPath,
            'foto_akhir' => $fotoAkhirPath,
            'deskripsi' => $request->deskripsi,
            'oleh' => $request->oleh,
            'kepada' => $request->kepada,
        ]);

        return redirect()->route('mahasiswa.pelaporan.lapor_inventaris.index')
            ->with('success', 'Laporan peminjaman inventaris berhasil disimpan.');
    }

    public function show($id)
    {
        $laporan = LaporInventaris::with(['mahasiswa', 'logistik'])->find($id);

        if ($laporan) {
            return view('mahasiswa.lapor_inventaris.show', compact('laporan'));
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    public function update(Request $request, $id_lapor_inventaris)
    {
        $laporan = LaporInventaris::find($id_lapor_inventaris);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'id_logistik' => 'sometimes|required|integer',
            'id_mahasiswa' => 'sometimes|required|integer',
            'datetime' => 'sometimes|required|date',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'nullable|string|max:255',
            'oleh'=> 'required',
            'kepada'=> 'required',
        ]);

        $laporan->update($request->all());

        return redirect()->route('mahasiswa.lapor_inventaris.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $laporan = LaporInventaris::find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $laporan->delete();

        return redirect()->route('mahasiswa.lapor_inventaris.index')
        ->with('success', 'Data berhasil dihapus');
    }
}
