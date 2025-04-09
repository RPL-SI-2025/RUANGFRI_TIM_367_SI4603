<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\laporinventaris;

class laporinventarisController extends Controller
{
    public function index()
    {
        $laporan = laporinventaris::all();
        return response()->json($laporan);
    }

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

        return response()->json(['message' => 'Laporan berhasil ditambahkan', 'data' => $laporan]);
    }

    public function show($id)
    {
        $laporan = laporinventaris::find($id);
        if ($laporan) {
            return response()->json($laporan);
        }
        return response()->json(['message' => 'Data tidak ditemukan'], 404);
    }

    public function update(Request $request, $id)
    {
        $laporan = laporinventaris::find($id);
        if (!$laporan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
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

        return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $laporan]);
    }

    public function destroy($id)
    {
        $laporan = laporinventaris::find($id);
        if (!$laporan) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $laporan->delete();
        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}