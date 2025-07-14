<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{
    public $lokasiOptions = [
        'Gedung B (Cacuk)',
        'Telkom University Landmark Tower (TULT)',
        'Gedung Kuliah Umum (GKU)',
    ];

    // ========== MAHASISWA ==========
    public function mahasiswaIndex(Request $request)
    {
        $query = Ruangan::query();

        if ($request->filled('search')) {
            $query->where('nama_ruangan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('lokasi') && in_array($request->lokasi, $this->lokasiOptions)) {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ruangans = $query->paginate(9)->withQueryString();

        return view('mahasiswa.katalog.ruangan.index', [
            'ruangans' => $ruangans,
            'lokasiOptions' => $this->lokasiOptions,
        ]);
    }

    public function mahasiswaShow($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('mahasiswa.katalog.ruangan.show', compact('ruangan'));
    }

    // ========== ADMIN ==========
    public function index(Request $request)
    {
        $query = Ruangan::query();

        if ($request->filled('search')) {
            $query->where('nama_ruangan', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('lokasi')) {
            $query->where('lokasi', $request->lokasi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ruangans = $query->get();

        return view('admin.katalog_ruangan.index', compact('ruangans'));
    }

    public function show($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return redirect()->route('admin.katalog_ruangan.index')
                             ->with('error', 'Ruangan tidak ditemukan');
        }

        return view('admin.katalog_ruangan.show', compact('ruangan'));
    }

    public function create()
    {
        return view('admin.katalog_ruangan.create', [
            'lokasiOptions' => $this->lokasiOptions
        ]);
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
            $file = $request->file('gambar');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/katalog_ruangan', $filename);
            $validatedData['gambar'] = $filename;
        }

        Ruangan::create($validatedData);

        return redirect()->route('admin.katalog_ruangan.index')
                         ->with('success', 'Ruangan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return redirect()->route('admin.katalog_ruangan.index')
                             ->with('error', 'Ruangan tidak ditemukan');
        }

        $fasilitasArray = explode(', ', $ruangan->fasilitas);

        return view('admin.katalog_ruangan.edit', [
            'ruangan' => $ruangan,
            'lokasiOptions' => $this->lokasiOptions,
            'fasilitasArray' => $fasilitasArray,
        ]);
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return redirect()->route('admin.katalog_ruangan.index')
                             ->with('error', 'Ruangan tidak ditemukan');
        }

        $validatedData = $request->validate([
            'nama_ruangan' => 'required|unique:ruangan,nama_ruangan,' . $id,
            'kapasitas'    => 'required|integer|min:10|max:300',
            'fasilitas'    => 'required|array|min:1',
            'fasilitas.*'  => 'required|string',
            'lokasi'       => 'required|in:' . implode(',', $this->lokasiOptions),
            'status'       => 'required|in:Tersedia,Tidak Tersedia',
            'gambar'       => 'nullable|image|max:2048',
        ]);

        $validatedData['fasilitas'] = implode(', ', $validatedData['fasilitas']);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($ruangan->gambar) {
                Storage::delete('public/katalog_ruangan/' . $ruangan->gambar);
            }

            $file = $request->file('gambar');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/katalog_ruangan', $filename);
            $validatedData['gambar'] = $filename;
        }

        $ruangan->update($validatedData);

        return redirect()->route('admin.katalog_ruangan.index')
                         ->with('success', 'Ruangan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::find($id);

        if (!$ruangan) {
            return redirect()->route('admin.katalog_ruangan.index')
                             ->with('error', 'Ruangan tidak ditemukan');
        }

        if ($ruangan->gambar) {
            Storage::disk('public')->delete('katalog_ruangan/' . $ruangan->gambar);
        }

        $ruangan->delete();

        return redirect()->route('admin.katalog_ruangan.index')
                         ->with('success', 'Ruangan berhasil dihapus!');
    }
}