<?php

namespace App\Http\Controllers;

use App\Models\laporinventaris;
use Illuminate\Http\Request;

class laporinventarisController extends Controller
{
   
    public function index()
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->get();
        return view('lapor_inventaris.index', compact($laporan));
    }

   
    public function create()
    {
        return view('lapor_inventaris.create');
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
        return redirect()->route('lapor_inventaris.index')
        ->with('success', 'Laporan berhasil ditambahkan');
    }

    public function show($id)
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->find($id);

        if ($laporan) {
            return view('laporinventaris.show', compact($laporan));
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

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
            'deskripsi' => 'nullable|string|max:255',
            'oleh'=> 'required',
            'kepada'=> 'required',
        ]);

        $laporan->update($request->all());

        return redirect()->route('lapor_inventaris.index')
        ->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $laporan = laporinventaris::find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $laporan->delete();

        return redirect()->route('lapor_inventaris.index')
        ->with('success', 'Data berhasil dihapus');
    }
}
