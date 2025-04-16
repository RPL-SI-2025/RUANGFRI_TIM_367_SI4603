<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;

class PelaporanController extends Controller
{
    public function index()
    {
        $pelaporans = Pelaporan::all();
        return view('pelaporan.index', compact('pelaporans'));
    }

    public function create()
    {
        return view('pelaporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'oleh' => 'required',
            'kepada' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        Pelaporan::create($request->all());

        return redirect()->route('pelaporan.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);
        return view('pelaporan.edit', compact('pelaporan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'oleh' => 'required',
            'kepada' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required',
        ]);

        $pelaporan = Pelaporan::findOrFail($id);
        $pelaporan->update($request->all());

        return redirect()->route('pelaporan.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelaporan = Pelaporan::findOrFail($id);
        $pelaporan->delete();

        return redirect()->route('pelaporan.index')->with('success', 'Data berhasil dihapus.');
    }
}