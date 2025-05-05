<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class RuanganController extends Controller
{
    // Tampilkan daftar ruangan
    public function mahasiswaIndex(Request $request)
    {
        $query = Ruangan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        }

        $ruangans = $query->orderBy('nama_ruangan')->get();
        return view('mahasiswa.katalog.ruangan.index', compact('ruangans'));
    }

    // Tampilkan detail satu ruangan
    public function mahasiswaShow($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('mahasiswa.katalog.ruangan.show', compact('ruangan'));
    }





    // public function mahasiswaindex(Request $request)
    // {
    //     $query = Ruangan::query();

    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where('nama_ruangan', 'like', "%{$search}%")
    //               ->orWhere('lokasi', 'like', "%{$search}%");
    //     }

    //     $ruangans = $query->orderBy('nama_ruangan')->get();
    //     return view('mahasiswa.katalog.ruangan.index', compact('ruangans'));
    // }

    // public function mahasiswashow($id)
    // {
    //     $ruangan = Ruangan::find($id);
    //     if (is_null($ruangan)) {
    //         return redirect()->route('admin.katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
    //     }
    //     return view('mahasiswa.katalog.ruangan.show', compact('ruangan'));
    // }


    public function index(Request $request)
    {
        $query = Ruangan::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_ruangan', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%");
        }

        $ruangans = $query->orderBy('nama_ruangan')->get();
        return view('admin.katalog_ruangan.index', compact('ruangans'));
    }

    public function show($id)
    {
        $ruangan = Ruangan::find($id);
        if (is_null($ruangan)) {
            return redirect()->route('admin.katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }
        return view('admin.katalog_ruangan.show', compact('ruangan'));
    }

    public function create()
    {
        return view('admin.katalog_ruangan.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nama_ruangan' => 'required|unique:ruangan,nama_ruangan',
        'kapasitas'    => 'required|integer|min:10|max:300',
        'fasilitas'    => 'required|string',
        'lokasi'       => 'required|string',
        'status'       => 'required|in:Tersedia,Tidak Tersedia',
        'gambar'       => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('gambar')) {
        $file     = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();

        Storage::disk('public')->makeDirectory('katalog_ruangan');
        Storage::disk('public')->putFileAs('katalog_ruangan', $file, $filename);

        // Simpan hanya nama file, nanti di view dipanggil via asset('storage/…')
        $validatedData['gambar'] = $filename;
    }

    Ruangan::create($validatedData);

    return redirect()
        ->route('admin.katalog_ruangan.index')
        ->with('success', 'Ruangan berhasil ditambahkan!');
}


    public function edit($id)
    {
        $ruangan = Ruangan::find($id);

        if (is_null($ruangan)) {
            return redirect()->route('admin.katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }

        return view('admin.katalog_ruangan.edit', compact('ruangan'));
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);

        if (is_null($ruangan)) {
            return redirect()->route('admin.katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }

        $validatedData = $request->validate([
            'nama_ruangan' => 'required|unique:ruangan,nama_ruangan,' . $id . ',id',
            'kapasitas' => 'required|integer|min:10|max:40',
            'fasilitas' => 'required|string',
            'lokasi' => 'required|string',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($ruangan->gambar) {
                $gambarLama = str_replace('/storage/', 'public/', $ruangan->gambar);
                Storage::delete($gambarLama);
            }

            $image = $request->file('gambar');
            $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/katalog_ruangan', $imageName);
            $validatedData['gambar'] = Storage::url($imagePath);
        }

        $ruangan->update($validatedData);

        return redirect()->route('admin.katalog_ruangan.index')->with('success', 'Ruangan berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $ruangan = Ruangan::find($id);

        if (is_null($ruangan)) {
            return redirect()->route('admin.katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
        }

        if ($ruangan->gambar) {
            $gambarPath = str_replace('/storage/', 'public/', $ruangan->gambar);
            Storage::delete($gambarPath);
        }

        $ruangan->delete();

        return redirect()->route('admin.katalog_ruangan.index')->with('success', 'Ruangan berhasil dihapus!');
    }
}
