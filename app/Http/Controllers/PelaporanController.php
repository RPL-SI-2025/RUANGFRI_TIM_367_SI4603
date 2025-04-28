<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use Illuminate\Support\Facades\Storage;

class PelaporanController extends Controller
{
    public function index()
    {
        $pelaporans = Pelaporan::all();
        return view('pelaporans.index', compact('pelaporans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_mahasiswa' => 'required|integer',
            'id_logistik' => 'required|integer',
            'datetime' => 'required|date',
            'deskripsi' => 'nullable|string',
            'oleh' => 'required|string',
            'kepada' => 'required|string',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_awal')) {
            $data['foto_awal'] = $request->file('foto_awal')->store('foto_awal');
        }

        if ($request->hasFile('foto_akhir')) {
            $data['foto_akhir'] = $request->file('foto_akhir')->store('foto_akhir');
        }

        return LaporanRuangan::create($data);
    }

    public function show($id)
    {
        return LaporanRuangan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanRuangan::findOrFail($id);

        $data = $request->validate([
            'id_mahasiswa' => 'sometimes|integer',
            'id_logistik' => 'sometimes|integer',
            'datetime' => 'sometimes|date',
            'deskripsi' => 'nullable|string',
            'oleh' => 'sometimes|string',
            'kepada' => 'sometimes|string',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto_awal')) {
            if ($laporan->foto_awal) {
                Storage::delete($laporan->foto_awal);
            }
            $data['foto_awal'] = $request->file('foto_awal')->store('foto_awal');
        }

        if ($request->hasFile('foto_akhir')) {
            if ($laporan->foto_akhir) {
                Storage::delete($laporan->foto_akhir);
            }
            $data['foto_akhir'] = $request->file('foto_akhir')->store('foto_akhir');
        }

        $laporan->update($data);

        return $laporan;
    }

    public function destroy($id)
    {
        $laporan = LaporanRuangan::findOrFail($id);

        if ($laporan->foto_awal) {
            Storage::delete($laporan->foto_awal);
        }

        if ($laporan->foto_akhir) {
            Storage::delete($laporan->foto_akhir);
        }

        $laporan->delete();

        return response()->json(['message' => 'Laporan deleted']);
    }
}