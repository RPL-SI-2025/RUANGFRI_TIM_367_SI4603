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
        return response()->json($laporan);
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

        return response()->json([
            'message' => 'Laporan berhasil ditambahkan',
            'data' => $laporan
        ]);
    }

    // Tampilkan data laporan by ID + relasi
    public function show($id)
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->find($id);

        if ($laporan) {
            return response()->json($laporan);
        }

        return response()->json(['message' => 'Data tidak ditemukan']);
    }

    // Update data
    public function update(Request $request, $id)
    {
        $laporan = laporinventaris::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Data tidak ditemukan']);
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

        return response()->json([
            'message' => 'Data berhasil diperbarui',
            'data' => $laporan
        ]);
    }

    // Hapus data
    public function destroy($id)
    {
        $laporan = laporinventaris::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Data tidak ditemukan']);
        }

        $laporan->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
