<?php

namespace App\Http\Controllers;

use App\Models\laporinventaris;
use Illuminate\Http\Request;

class laporinventarisController extends Controller
{
   
    public function index()
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->get();
        return view('admin.lapor_inventaris.index', compact('laporan'));
    }

   
    public function create()
    {
        return view('admin.lapor_inventaris.create');
    }

    public function edit($id)
    {
        $laporan = laporinventaris::find($id);

        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        return view('admin.lapor_inventaris.edit', compact('laporan'));
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

        laporInventaris::create($request->all());
        return redirect()->route('admin.lapor_inventaris.index')->with('success', 'Laporan berhasil ditambahkan');
    }

    public function show($id)
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->find($id);

        if ($laporan) {
            return view('admin.lapor_inventaris.show', compact('laporan'));
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    public function update(Request $request, $id_lapor_inventaris)
    {
        $laporan = laporinventaris::find($id_lapor_inventaris);

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

        return redirect()->route('admin.lapor_inventaris.index')
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
