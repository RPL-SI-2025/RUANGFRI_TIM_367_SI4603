<?php

namespace App\Http\Controllers;

use App\Models\laporinventaris;  // Menggunakan LaporInventaris dengan PascalCase
use App\Models\AdminLogistik;
use Illuminate\Http\Request;
use App\Models\PinjamInventaris;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class laporinventarisController extends Controller
{
   
    public function index()
    {

        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->get();
        return view('admin.lapor_inventaris.index', compact('laporan'));
    }
    
    // Pertahankan method show untuk admin
    public function show($id)
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->find($id);
    
        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    
        return view('admin.lapor_inventaris.show', compact('laporan'));
    }

    
    public function mahasiswaIndex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = laporinventaris::where('id_mahasiswa', $mahasiswaId)
                    ->with('logistik')
                    ->latest('datetime')
                    ->get();
                    
        return view('mahasiswa.pelaporan.lapor_inventaris.index', compact('laporan'));
    }

    public function mahasiswaCreate(Request $request)
    {
    $mahasiswaId = Session::get('mahasiswa_id');
    
    if (!$mahasiswaId) {
        return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    $peminjamanId = $request->id_peminjaman;
    $peminjaman = null;
    
    if ($peminjamanId) {
        // Get the first item of the peminjaman group with the same details
        $peminjaman = PinjamInventaris::with('inventaris')
                        ->where('id', $peminjamanId)
                        ->where('id_mahasiswa', $mahasiswaId)
                        ->first();
                        
        if (!$peminjaman) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('error', 'Peminjaman tidak ditemukan.');
        }
        
        if ($peminjaman->status != 1) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('error', 'Hanya peminjaman yang sudah disetujui yang dapat dilaporkan selesai.');
        }
        
        // Get all related items with the same request details
        $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $peminjaman->tanggal_pengajuan)
            ->where('tanggal_selesai', $peminjaman->tanggal_selesai)
            ->where('waktu_mulai', $peminjaman->waktu_mulai)
            ->where('waktu_selesai', $peminjaman->waktu_selesai)
            ->where('file_scan', $peminjaman->file_scan)
            ->where('id_mahasiswa', $mahasiswaId)
            ->with('inventaris')
            ->get();
    }
    
    // Get admin users for the dropdown
    $adminLogistik = AdminLogistik::all();
    
    return view('mahasiswa.pelaporan.lapor_inventaris.create', compact('peminjaman', 'relatedItems', 'adminLogistik'));
    }


    public function mahasiswaStore(Request $request)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $request->validate([
            'id_logistik' => 'required|integer',
            'datetime' => 'required|date',
            'foto_awal' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string',
            'id_peminjaman' => 'required|integer',
        ]);
        
        // Upload foto awal
        $fotoAwalPath = null;
        if ($request->hasFile('foto_awal')) {
            $fotoAwal = $request->file('foto_awal');
            $fotoAwalFilename = time() . '_awal_' . $fotoAwal->getClientOriginalName();
            $fotoAwalPath = $fotoAwal->storeAs('foto_laporan', $fotoAwalFilename, 'public');
        }
        
        // Upload foto akhir
        $fotoAkhirPath = null;
        if ($request->hasFile('foto_akhir')) {
            $fotoAkhir = $request->file('foto_akhir');
            $fotoAkhirFilename = time() . '_akhir_' . $fotoAkhir->getClientOriginalName();
            $fotoAkhirPath = $fotoAkhir->storeAs('foto_laporan', $fotoAkhirFilename, 'public');
        }
        
        // Create laporan
        $laporan = laporinventaris::create([
            'id_logistik' => $request->id_logistik,
            'id_mahasiswa' => $mahasiswaId,
            'datetime' => $request->datetime,
            'foto_awal' => $fotoAwalPath,
            'foto_akhir' => $fotoAkhirPath,
            'deskripsi' => $request->deskripsi,
            'oleh' => 'Mahasiswa',
            'kepada' => 'Admin Logistik'
        ]);
        
        // Update status peminjaman menjadi selesai (3) for ALL related items in the group
        if ($request->id_peminjaman) {
            $peminjaman = PinjamInventaris::find($request->id_peminjaman);
            
            if ($peminjaman && $peminjaman->id_mahasiswa == $mahasiswaId) {
                // Mark all related items with the same details as complete
                PinjamInventaris::where('tanggal_pengajuan', $peminjaman->tanggal_pengajuan)
                    ->where('tanggal_selesai', $peminjaman->tanggal_selesai)
                    ->where('waktu_mulai', $peminjaman->waktu_mulai)
                    ->where('waktu_selesai', $peminjaman->waktu_selesai)
                    ->where('file_scan', $peminjaman->file_scan)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->update(['status' => 3]); // Status selesai
            }
        }
        
        return redirect()->route('mahasiswa.pelaporan.lapor_inventaris.index')
            ->with('success', 'Laporan berhasil dikirim dan peminjaman ditandai selesai.');
    }

    public function mahasiswaEdit($id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = laporinventaris::where('id_lapor_inventaris', $id)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->first();
                    
        if (!$laporan) {
            return redirect()->route('mahasiswa.lapor_inventaris.index')
                ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }
        
        return view('mahasiswa.pelaporan.lapor_inventaris.edit', compact('laporan'));
    }

    public function mahasiswaUpdate(Request $request, $id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = laporinventaris::where('id_lapor_inventaris', $id)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->first();
                    
        if (!$laporan) {
            return redirect()->route('mahasiswa.lapor_inventaris.index')
                ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }
        
        $request->validate([
            'deskripsi' => 'required|string',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Update foto awal jika ada
        if ($request->hasFile('foto_awal')) {
            // Hapus foto lama jika ada
            if ($laporan->foto_awal) {
                Storage::disk('public')->delete($laporan->foto_awal);
            }
            
            $fotoAwal = $request->file('foto_awal');
            $fotoAwalFilename = time() . '_awal_' . $fotoAwal->getClientOriginalName();
            $laporan->foto_awal = $fotoAwal->storeAs('foto_laporan', $fotoAwalFilename, 'public');
        }
        
        // Update foto akhir jika ada
        if ($request->hasFile('foto_akhir')) {
            // Hapus foto lama jika ada
            if ($laporan->foto_akhir) {
                Storage::disk('public')->delete($laporan->foto_akhir);
            }
            
            $fotoAkhir = $request->file('foto_akhir');
            $fotoAkhirFilename = time() . '_akhir_' . $fotoAkhir->getClientOriginalName();
            $laporan->foto_akhir = $fotoAkhir->storeAs('foto_laporan', $fotoAkhirFilename, 'public');
        }
        
        $laporan->deskripsi = $request->deskripsi;
        $laporan->save();
        
        return redirect()->route('mahasiswa.pelaporan.lapor_inventaris.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function mahasiswaShow($id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = laporinventaris::where('id_lapor_inventaris', $id)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->with('logistik')
                    ->first();
                    
        if (!$laporan) {
            return redirect()->route('mahasiswa.lapor_inventaris.index')
                ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }
        
        return view('mahasiswa.pelaporan.lapor_inventaris.show', compact('laporan'));
    }
}
