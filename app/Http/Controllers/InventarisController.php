<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::all();
        return view('admin.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('admin.inventaris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_inventaris' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        Inventaris::create($request->all());

        return redirect()->route('admin.inventaris.index')->with('success', 'Inventaris berhasil ditambahkan.');
    }

    public function edit(Inventaris $inventaris)
    {
        return view('admin.inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate([
            'nama_inventaris' => 'required|string',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|integer',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        $inventaris->update($request->all());

        return redirect()->route('admin.inventaris.index')->with('success', 'Inventaris berhasil diperbarui.');
    }

    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();

        return redirect()->route('admin.inventaris.index')->with('success', 'Inventaris berhasil dihapus.');
    }
}
