<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventaris;
use App\Models\KategoriInventaris;
use Illuminate\Support\Facades\Storage;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $inventaris = Inventaris::with('kategori')->get();
        return view('admin.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        $kategoris = KategoriInventaris::all();
        return view('admin.inventaris.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'gambar_inventaris' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_inventaris'   => 'required|string|unique:inventaris,nama_inventaris',
            'kategori_id'       => 'required|exists:kategori_inventaris,id',
            'deskripsi'         => 'required|string',
            'jumlah'            => 'required|integer',
            'status'            => 'required|in:Tersedia,Tidak Tersedia',
        ], [
            'nama_inventaris.unique' => 'inventaris sudah ada.',
            'gambar_inventaris.required' => 'Gambar inventaris wajib diunggah.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
        ]);

        Storage::disk('public')->makeDirectory('katalog_inventaris');

        $file     = $request->file('gambar_inventaris');
        $filename = time() . '_' . $file->getClientOriginalName();
        Storage::disk('public')->putFileAs('katalog_inventaris', $file, $filename);

        $data['gambar_inventaris'] = $filename;

        Inventaris::create($data);

        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Inventaris berhasil ditambahkan.');
    }


    public function edit(Inventaris $inventaris)
    {
        $kategoris = KategoriInventaris::all();
        return view('admin.inventaris.edit', compact('inventaris', 'kategoris'));
    }

    public function update(Request $request, Inventaris $inventaris)
    {
        $data = $request->validate([
            'gambar_inventaris' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nama_inventaris'   => 'required|string',
            'kategori_id'       => 'required|exists:kategori_inventaris,id',
            'deskripsi'         => 'required|string',
            'jumlah'            => 'required|integer',
            'status'            => 'required|in:Tersedia,Tidak Tersedia',
        ]);

        if ($request->hasFile('gambar_inventaris')) {
            $file     = $request->file('gambar_inventaris');
            $filename = time() . '_' . $file->getClientOriginalName();

            Storage::disk('public')->makeDirectory('katalog_inventaris');

            Storage::disk('public')->putFileAs('katalog_inventaris', $file, $filename);

            if ($inventaris->gambar_inventaris) {
                Storage::disk('public')->delete('katalog_inventaris/' . $inventaris->gambar_inventaris);
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
            Storage::disk('public')->delete('katalog_inventaris/' . $inventaris->gambar_inventaris);
        }

        $inventaris->delete();

        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Inventaris dan gambarnya berhasil dihapus.');
    }

    public function mahasiswaIndex(Request $request)
    {
        $query = Inventaris::with('kategori');


        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_inventaris', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }


        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        $inventaris = $query->latest()->get();
        $kategoris = KategoriInventaris::all();

        return view('mahasiswa.katalog.inventaris.index', compact('inventaris', 'kategoris'));
    }

    public function mahasiswaShow($id)
    {
        $inventaris = Inventaris::findOrFail($id);
        return view('mahasiswa.katalog.inventaris.show', compact('inventaris'));
    }
}
