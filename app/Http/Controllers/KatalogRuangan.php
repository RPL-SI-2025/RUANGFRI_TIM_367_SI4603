<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KatalogRuanganController extends Controller
    {
        public function index (Request $request)
        {
            $query = Ruangan::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
            }

            $ruangans = $query->orderBy('nama_ruangan')->get();
            return view('katalog_ruangan.index', compact('ruangans'));
        }

        public function show($id)
        {
            $ruangan = Ruangan::find($id);
            if(is_null($ruangan)) {
                return redirect()->route('admin_katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
            }
            return view('katalog_ruangan.show', compact('ruangan'));
        }

        public function adminindex (Request $request)
        {
            $query = Ruangan::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('lokasi', 'like', "%{$search}%");
            }

            $ruangans = $query->orderBy('nama_ruangan')->get();
            return view('admin.katalog_ruangan.index', compact('ruangans'));
        }
        public function adminshow($id)
        {
            $ruangan = Ruangan::find($id);
            if(is_numm($ruangan)) {
                return redirect()->route('admin_katalog_ruangan.index')->with('error', 'Ruangan tidak ditemukan');
            }
            return view('admin.katalog_ruangan.show', compact('ruangan'));
        }

        public function admincreate()
        {
            return view ('admin.katalog_ruangan.create');
        }

        public function adminstore()
        {
            $validatedData = request()->validate([
                'nama_ruangan' => 'required|unique:ruangan,nama_ruangan',
                'kapasitas' => 'required|integer|min:10|max:40',
                'fasilitas' => 'required|string',
                'lokasi' => 'required|string',
                'status' => 'required|in:Tersedia,Tidak Tersedia',
                'gambar' => 'nullable|image|max:2048',
            ]);

            if (request()->hasFile('gambar')) {
                $image = request()->file('gambar');
                $imageName = Str::random(10) . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('public/katalog_ruangan', $imageName);
                $imageUrl = Storage::url($imagePath);

                $validatedData['gambar'] = $imageUrl;
            }

            KatalogRuangan::create($validatedData);

            return view('admin.katalog_ruangan.index')->with('success', 'Ruangan berhasil ditambahkan!');
        }


    }
