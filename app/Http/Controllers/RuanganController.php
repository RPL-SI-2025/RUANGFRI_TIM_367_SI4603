<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class RuanganController extends Controller
{

    private $lokasiOptions = [
        'Gedung B (Cacuk)',
        'Telkom University Landmark Tower (TULT)',
        'Gedung Kuliah Umum (GKU)',
    ];

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


    public function mahasiswaShow($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('mahasiswa.katalog.ruangan.show', compact('ruangan'));
    }





    public function index(Request $request)
    {
        $query = Ruangan::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_ruangan', 'like', '%' . $request->search . '%');
        }

        if ($request->has('lokasi') && $request->lokasi != '') {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $ruangans = $query->get();

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
         $lokasiOptions = $this->lokasiOptions;
        return view('admin.katalog_ruangan.create');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'nama_ruangan' => 'required|unique:ruangan,nama_ruangan',
        'kapasitas'    => 'required|integer|min:10|max:300',
        'fasilitas'    => 'required|array|min:1',
        'fasilitas.*'  => 'required|string',
        'lokasi'       => 'required|in:' . implode(',', $this->lokasiOptions),
        'status'       => 'required|in:Tersedia,Tidak Tersedia',
        'gambar'       => 'nullable|image|max:2048',
    ]);

     $validatedData['fasilitas'] = implode(', ', $validatedData['fasilitas']);

    if ($request->hasFile('gambar')) {
        $file     = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();

        Storage::disk('public')->makeDirectory('katalog_ruangan');
        Storage::disk('public')->putFileAs('katalog_ruangan', $file, $filename);

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

        $lokasiOptions = $this->lokasiOptions;
        $fasilitasArray = explode(', ', $ruangan->fasilitas);

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
            'kapasitas' => 'required|integer|min:10|max:300',
            'fasilitas'    => 'required|array|min:1',
            'fasilitas.*'  => 'required|string',
            'lokasi'       => 'required|in:' . implode(',', $this->lokasiOptions),
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $validatedData['fasilitas'] = implode(', ', $validatedData['fasilitas']);

        if ($request->hasFile('gambar')) {
            if ($ruangan->gambar) {
                Storage::disk('public')->delete('katalog_ruangan/' . $ruangan->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();

            Storage::disk('public')->makeDirectory('katalog_ruangan');
            Storage::disk('public')->putFileAs('katalog_ruangan', $file, $filename);

            $validatedData['gambar'] = $filename;
        }

        $ruangan->update($validatedData);

        return redirect()
        ->route('admin.katalog_ruangan.index')
        ->with('success', 'Ruangan berhasil diperbarui!');
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
