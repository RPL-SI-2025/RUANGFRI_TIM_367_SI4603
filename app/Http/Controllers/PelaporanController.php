<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\AdminLogistik;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PelaporanController extends Controller
{

    public function index()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $pelaporans = Pelaporan::where('id_mahasiswa', Auth::id())->get();
        return view('mahasiswa.pelaporan.lapor_ruang.index', compact('pelaporans'));
    }

    public function create()
    {
        return view('mahasiswa.pelaporan.lapor_ruang.create');

    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_logistik' => 'required|integer',
            'datetime' => 'required|date',
            'deskripsi' => 'nullable|string',
            'oleh' => 'required|string',
            'kepada' => 'required|string',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

       
        if (!AdminLogistik::where('id', $data['id_logistik'])->exists()) {
            throw ValidationException::withMessages([
                'id_logistik' => 'Data tidak tersedia di database',
            ]);
        }

        
        $data['id_mahasiswa'] = Auth::id();

        if ($request->hasFile('foto_awal')) {
            $data['foto_awal'] = $request->file('foto_awal')->store('foto_awal', 'public');
        }

        if ($request->hasFile('foto_akhir')) {
            $data['foto_akhir'] = $request->file('foto_akhir')->store('foto_akhir', 'public');
        }

        $pelaporan = Pelaporan::create($data);

        return redirect()->route('mahasiswa.pelaporan.lapor_ruang.index')->with('success', 'Laporan created successfully');
    }

    public function show($id)
    {
        $pelaporan = Pelaporan::where('id_lapor_ruangan', $id)
            ->where('id_mahasiswa', Auth::id())
            ->firstOrFail();
        return view('mahasiswa.pelaporan.lapor_ruang.show', compact('pelaporan'));
    }

    public function edit($id)
    {
        $pelaporan = Pelaporan::where('id_lapor_ruangan', $id)
            ->where('id_mahasiswa', Auth::id())
            ->firstOrFail();
        $logistiks = AdminLogistik::all();
        return view('mahasiswa.pelaporan.lapor_ruang.edit', compact('pelaporan', 'logistiks'));
    }

    public function update(Request $request, $id)
    {
        $pelaporan = Pelaporan::where('id_lapor_ruangan', $id)
            ->where('id_mahasiswa', Auth::id())
            ->firstOrFail();

        $data = $request->validate([
            'id_logistik' => 'sometimes|integer',
            'datetime' => 'sometimes|date',
            'deskripsi' => 'nullable|string',
            'oleh' => 'sometimes|string',
            'kepada' => 'sometimes|string',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        
        if (isset($data['id_logistik']) && !AdminLogistik::where('id', $data['id_logistik'])->exists()) {
            throw ValidationException::withMessages([
                'id_logistik' => 'Data tidak tersedia di database',
            ]);
        }

        if ($request->hasFile('foto_awal')) {
            if ($pelaporan->foto_awal) {
                Storage::disk('public')->delete($pelaporan->foto_awal);
            }
            $data['foto_awal'] = $request->file('foto_awal')->store('foto_awal', 'public');
        }

        if ($request->hasFile('foto_akhir')) {
            if ($pelaporan->foto_akhir) {
                Storage::disk('public')->delete($pelaporan->foto_akhir);
            }
            $data['foto_akhir'] = $request->file('foto_akhir')->store('foto_akhir', 'public');
        }

        $pelaporan->update($data);

        return redirect()->route('mahasiswa.pelaporan.lapor_ruang.index')->with('success', 'Laporan updated successfully');
    }

    public function destroy($id)
    {
        $pelaporan = Pelaporan::where('id_lapor_ruangan', $id)
            ->where('id_mahasiswa', Auth::id())
            ->firstOrFail();

        if ($pelaporan->foto_awal) {
            Storage::disk('public')->delete($pelaporan->foto_awal);
        }

        if ($pelaporan->foto_akhir) {
            Storage::disk('public')->delete($pelaporan->foto_akhir);
        }

        $pelaporan->delete();

        return redirect()->route('mahasiswa.pelaporan.lapor_ruang.index')->with('success', 'Laporan deleted successfully');
    }

    // admin
    public function adminIndex(Request $request)
    {
        
        $pelaporans = Pelaporan::with(['mahasiswa', 'logistik'])
            ->latest('datetime') 
            ->get();

        
        $groupedPelaporans = $pelaporans->groupBy(function ($item) {
            return $item->datetime . '-' . $item->oleh . '-' . $item->kepada . '-' . 
                   $item->foto_awal . '-' . $item->foto_akhir . '-' . $item->id_mahasiswa;
        });

        
        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $groupedPelaporans->forPage($currentPage, $perPage);

        $paginatedGroupedPelaporans = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $groupedPelaporans->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}