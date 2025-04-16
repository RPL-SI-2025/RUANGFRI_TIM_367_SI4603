<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;

class PelaporanController extends Controller
{
    public function index()
    {
        return Pelaporan::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_mahasiswa' => 'required|integer',
            'id_logistik' => 'required|integer',
            'datetime' => 'required|date',
            'foto_awal' => 'nullable|string',
            'foto_akhir' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'oleh' => 'required|string',
            'kepada' => 'required|string',
        ]);

        return Pelaporan::create($validated);
    }

    public function show($id)
    {
        return Pelaporan::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $pelaporan = Pelaporan::findOrFail($id);
        $pelaporan->update($request->all());
        return $pelaporan;
    }

    public function destroy($id)
    {
        Pelaporan::destroy($id);
        return response()->json(['message' => 'Deleted']);
    }
}