<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'waktu' => 'required'
        ]);

        Pelaporan::create($request->all());
        return redirect()->route('pelaporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    public function edit(Pelaporan $pelaporan)
    {
        return view('pelaporan.edit', compact('pelaporan'));
    }

    public function update(Request $request, Pelaporan $pelaporan)
    {
        $request->validate([
            'oleh' => 'required',
            'kepada' => 'required',
            'tanggal' => 'required|date',
            'waktu' => 'required'
        ]);

        $pelaporan->update($request->all());
        return redirect()->route('pelaporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(Pelaporan $pelaporan)
    {
        $pelaporan->delete();
        return redirect()->route('pelaporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}