<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventaris;
use Illuminate\Support\Facades\Storage;

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
    $data = $request->validate([
        'gambar_inventaris' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'nama_inventaris'   => 'required|string|unique:inventaris,nama_inventaris',
        'deskripsi'         => 'required|string',
        'jumlah'            => 'required|integer',
        'status'            => 'required|in:Tersedia,Tidak Tersedia',
    ], [
        'nama_inventaris.unique' => 'inventaris sudah ada.',
        'gambar_inventaris.required' => 'Gambar inventaris wajib diunggah.',
        'jumlah.integer' => 'Jumlah harus berupa angka.',
    ]);

    Storage::disk('public')->makeDirectory('inventaris');

    $file     = $request->file('gambar_inventaris');
    $filename = time() . '_' . $file->getClientOriginalName();
    Storage::disk('public')->putFileAs('inventaris', $file, $filename);

    $data['gambar_inventaris'] = $filename;

    Inventaris::create($data);

    return redirect()
        ->route('admin.inventaris.index')
        ->with('success', 'Inventaris berhasil ditambahkan.');
}



    public function edit(Inventaris $inventaris)
    {
        return view('admin.inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $data = $request->validate([
            'gambar_inventaris' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_inventaris'   => 'required|string',
            'deskripsi'         => 'required|string',
            'jumlah'            => 'required|integer',
            'status'            => 'required|in:Tersedia,Tidak Tersedia',
        ]);
    
        if ($request->hasFile('gambar_inventaris')) {
            $file     = $request->file('gambar_inventaris');
            $filename = time() . '_' . $file->getClientOriginalName();
    
            Storage::disk('public')->makeDirectory('inventaris');
    
            Storage::disk('public')->putFileAs('inventaris', $file, $filename);
    
            if ($inventaris->gambar_inventaris) {
                Storage::disk('public')->delete('inventaris/' . $inventaris->gambar_inventaris);
            }
    
            $data['gambar_inventaris'] = $filename;
        }
    
        $inventaris->update($data);
    
        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Inventaris berhasil diperbarui.');
    }
    
    

    public function destroy(Inventaris $inventaris)
    {
        if ($inventaris->gambar_inventaris) {
            Storage::disk('public')->delete('inventaris/' . $inventaris->gambar_inventaris);
        }
    
        $inventaris->delete();
    
        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Inventaris dan gambarnya berhasil dihapus.');
    }

    public function mahasiswaIndex()
    {
        $inventaris = Inventaris::all(); // tampilkan semua, tidak hanya yang tersedia
        return view('mahasiswa.katalog.inventaris.index', compact('inventaris'));
    }

    public function mahasiswaShow($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('mahasiswa.katalog.inventaris.show', compact('inventaris'));
    }
}