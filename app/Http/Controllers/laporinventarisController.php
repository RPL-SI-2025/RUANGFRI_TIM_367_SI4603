<?php

namespace App\Http\Controllers;

use App\Models\laporinventaris;  // Menggunakan LaporInventaris dengan PascalCase
use App\Models\AdminLogistik;
use Illuminate\Http\Request;
use App\Models\PinjamInventaris;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class laporinventarisController extends Controller
{
   
    public function index()
    {

        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->get();
        return view('admin.lapor_inventaris.index', compact('laporan'));
    }
    
    public function show($id)
    {
        $laporan = laporinventaris::with(['mahasiswa', 'logistik'])->find($id);
    
        if (!$laporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    
        return view('admin.lapor_inventaris.show', compact('laporan'));
    }

    public function history()
{
    $mahasiswaId = Session::get('mahasiswa_id');
    
    if (!$mahasiswaId) {
        return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    $laporan = laporinventaris::where('id_mahasiswa', $mahasiswaId)
                ->with(['peminjaman' => function($query) {
                    $query->where('status', 3); 
                }, 'logistik'])
                ->whereHas('peminjaman', function($query) {
                    $query->where('status', 3); 
                })
                ->latest('datetime')
                ->get();
                
    return view('mahasiswa.pelaporan.lapor_inventaris.history', compact('laporan'));
    
}
public function historyShow($id)
{
    $mahasiswaId = Session::get('mahasiswa_id');
    
    if (!$mahasiswaId) {
        return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
    }
    
    $laporan = laporinventaris::where('id_lapor_inventaris', $id)
                ->where('id_mahasiswa', $mahasiswaId)
                ->whereHas('peminjaman', function($query) {
                    $query->where('status', 3);
                })
                ->with(['logistik', 'peminjaman', 'mahasiswa'])
                ->first();
                
    if (!$laporan) {
        return redirect()->route('mahasiswa.pelaporan.lapor_inventaris.history')
            ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
    }
    

    $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $laporan->peminjaman->tanggal_pengajuan)
        ->where('tanggal_selesai', $laporan->peminjaman->tanggal_selesai)
        ->where('waktu_mulai', $laporan->peminjaman->waktu_mulai)
        ->where('waktu_selesai', $laporan->peminjaman->waktu_selesai)
        ->where('file_scan', $laporan->peminjaman->file_scan)
        ->where('id_mahasiswa', $mahasiswaId)
        ->with('inventaris')
        ->get();
    
    return view('mahasiswa.pelaporan.lapor_inventaris.history_show', compact('laporan', 'relatedItems'));
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
        
        $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $peminjaman->tanggal_pengajuan)
            ->where('tanggal_selesai', $peminjaman->tanggal_selesai)
            ->where('waktu_mulai', $peminjaman->waktu_mulai)
            ->where('waktu_selesai', $peminjaman->waktu_selesai)
            ->where('file_scan', $peminjaman->file_scan)
            ->where('id_mahasiswa', $mahasiswaId)
            ->with('inventaris')
            ->get();
    }
    
   
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
        
       
        $fotoAwalPath = null;
        if ($request->hasFile('foto_awal')) {
            $fotoAwal = $request->file('foto_awal');
            $fotoAwalFilename = time() . '_awal_' . $fotoAwal->getClientOriginalName();
            $fotoAwalPath = $fotoAwal->storeAs('foto_laporan', $fotoAwalFilename, 'public');
        }
        
        
        $fotoAkhirPath = null;
        if ($request->hasFile('foto_akhir')) {
            $fotoAkhir = $request->file('foto_akhir');
            $fotoAkhirFilename = time() . '_akhir_' . $fotoAkhir->getClientOriginalName();
            $fotoAkhirPath = $fotoAkhir->storeAs('foto_laporan', $fotoAkhirFilename, 'public');
        }
        
        
        $laporan = laporinventaris::create([
            'id_logistik' => $request->id_logistik,
            'id_mahasiswa' => $mahasiswaId,
            'id_pinjam_inventaris' => $request->id_peminjaman,
            'datetime' => $request->datetime,
            'foto_awal' => $fotoAwalPath,
            'foto_akhir' => $fotoAkhirPath,
            'deskripsi' => $request->deskripsi,
            'oleh' => 'Mahasiswa',
            'kepada' => 'Admin Logistik'
        ]);
        
        
        if ($request->id_peminjaman) {
            $peminjaman = PinjamInventaris::find($request->id_peminjaman);
            
            if ($peminjaman && $peminjaman->id_mahasiswa == $mahasiswaId) {
                
                PinjamInventaris::where('tanggal_pengajuan', $peminjaman->tanggal_pengajuan)
                    ->where('tanggal_selesai', $peminjaman->tanggal_selesai)
                    ->where('waktu_mulai', $peminjaman->waktu_mulai)
                    ->where('waktu_selesai', $peminjaman->waktu_selesai)
                    ->where('file_scan', $peminjaman->file_scan)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->update(['status' => 3]); 
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
  public function downloadPDF($id)
{
    $mahasiswaId = Session::get('mahasiswa_id');
    
    $laporan = laporinventaris::where('id_lapor_inventaris', $id)
        ->where('id_mahasiswa', $mahasiswaId)
        ->with(['mahasiswa', 'logistik', 'peminjaman'])
        ->firstOrFail();

    $pdf = Pdf::loadView('mahasiswa.pelaporan.lapor_inventaris.pdf', compact('laporan'));
    
    
    $pdf->setPaper('a4');
    

    $pdf->setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'sans-serif'
    ]);

    return $pdf->download('laporan-inventaris-' . $id . '.pdf');
}
}