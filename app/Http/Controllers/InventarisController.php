<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::all(); // ambil semua data dari tabel
        return view('admin.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        return view('admin.inventaris.create');
    }

    public function store(Request $request)
    {
        // Logic to store data
    }

    public function show($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.show', compact('inventaris'));
    }

    public function edit($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_inventaris' => 'required',
            'deskripsi' => 'required',
            'jumlah' => 'required|integer',
            'status' => 'required',
            'id_logistik' => 'required|integer',
        ]);
    
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update($request->all());
    
        return redirect()->route('inventaris.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy($id)
    {
        // Logic to delete data
    }

    public function mahasiswaIndex()
    {
        $inventaris = Inventaris::all(); // tampilkan semua, tidak hanya yang tersedia
        return view('mahasiswa.inventaris.index', compact('inventaris'));
    }

    // Fungsi untuk Mahasiswa melihat detail satu inventaris
    public function mahasiswaShow($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('mahasiswa.inventaris.show', compact('inventaris'));
    }



}

