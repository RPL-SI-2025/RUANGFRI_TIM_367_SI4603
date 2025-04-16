<?php

namespace App\Http\Controllers;

use App\Models\laporinventaris;
use Illuminate\Http\Request;

class laporinventarisController extends Controller
{
    // Ambil semua laporan dengan relasi mahasiswa dan logistik
    public function index()
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->get();
        return view('laporinventaris.index', compact($laporan));
    }

    // Form input (jika pakai blade)
    public function create()
    {
        return view('laporinventaris.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'id_logistik' => 'required|integer',
            'id_mahasiswa' => 'required|integer',
            'datetime' => 'required|date',
            'foto_awal' => 'nullable|string|max:255',
            'foto_akhir' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:255'
        ]);

        $laporan = laporinventaris::create($request->all());
        return redirect()->route('laporinventaris.index')
        ->with('success', 'Laporan berhasil ditambahkan');
    }

    // Tampilkan data laporan by ID + relasi
    public function show($id)
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->find($id);

        if ($laporan) {
            return view('laporinventaris.show', compact($laporan));
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // Update data
    public function update(Request $request, $id)
    {
        $laporan = laporinventaris::find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $request->validate([
            'id_logistik' => 'sometimes|required|integer',
            'id_mahasiswa' => 'sometimes|required|integer',
            'datetime' => 'sometimes|required|date',
            'foto_awal' => 'nullable|string|max:255',
            'foto_akhir' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:255'
        ]);

        $laporan->update($request->all());

        return redirect()->route('laporinventaris.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    // Hapus data
    public function destroy($id)
    {
        $laporan = laporinventaris::find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $laporan->delete();

        return redirect()->route('laporinventaris.index')
        ->with('success', 'Data berhasil dihapus');
    }
}
