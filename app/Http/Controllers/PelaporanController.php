<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\PinjamRuangan;
use App\Models\AdminLogistik;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
class PelaporanController extends Controller
{
    public function index()
    {
        $pelaporans = Pelaporan::all();
        return view('admin.lapor_ruangan.index', compact('pelaporans'));
    }


    public function show($id)
    {
        $pelaporan = Pelaporan::with(['mahasiswa', 'logistik', 'ruangan','peminjaman'])->find($id);
        
        if (!$pelaporan) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        
        return view('admin.lapor_ruangan.show', compact('pelaporan'));
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'keterangan' => 'required|string',
        ]);
        
 
        $pelaporan = Pelaporan::find($id);
        
        if (!$pelaporan) {
            return redirect()->route('admin.lapor_ruangan.index')
                ->with('error', 'Laporan tidak ditemukan.');
        }
        
 
        $pelaporan->keterangan = $request->keterangan;
        $pelaporan->save();
        
        return redirect()->route('admin.lapor_ruangan.show', $pelaporan->id_lapor_ruangan)
            ->with('success', 'Keterangan berhasil ditambahkan.');
    }

    public function mahasiswaIndex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = Pelaporan::where('id_mahasiswa', $mahasiswaId)
                    ->with(['logistik', 'ruangan', 'peminjaman']) 
                    ->latest('datetime')
                    ->get();
                    
        return view('mahasiswa.pelaporan.lapor_ruangan.index', compact('laporan'));
    }

    public function mahasiswaCreate(Request $request)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $peminjamanId = $request->id;
        $peminjaman = null;
        $relatedItems = null;
        
        if ($peminjamanId) {
   
            $peminjaman = PinjamRuangan::with('ruangan')
                            ->where('id', $peminjamanId)
                            ->where('id_mahasiswa', $mahasiswaId)
                            ->first();
                            
            if (!$peminjaman) {
                return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                    ->with('error', 'Peminjaman tidak ditemukan.');
            }
            
            if ($peminjaman->status != 1) {
                return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                    ->with('error', 'Hanya peminjaman yang sudah disetujui yang dapat dilaporkan selesai.');
            }
            

            $relatedItems = PinjamRuangan::where('tanggal_pengajuan', $peminjaman->tanggal_pengajuan)
                ->where('tanggal_selesai', $peminjaman->tanggal_selesai)
                ->where('waktu_mulai', $peminjaman->waktu_mulai)
                ->where('waktu_selesai', $peminjaman->waktu_selesai)
                ->where('file_scan', $peminjaman->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->with('ruangan')
                ->get();
        }
        

        $adminLogistik = AdminLogistik::all();
        

        $ruangan = \App\Models\Ruangan::all();
        
        return view('mahasiswa.pelaporan.lapor_ruangan.create', compact('peminjaman', 'relatedItems', 'adminLogistik', 'ruangan'));
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
        
        if ($request->id_peminjaman) {
            $peminjaman = PinjamRuangan::find($request->id_peminjaman);
            
            if ($peminjaman && $peminjaman->id_mahasiswa == $mahasiswaId) {

                PinjamRuangan::where('tanggal_pengajuan', $peminjaman->tanggal_pengajuan)
                    ->where('tanggal_selesai', $peminjaman->tanggal_selesai)
                    ->where('waktu_mulai', $peminjaman->waktu_mulai)
                    ->where('waktu_selesai', $peminjaman->waktu_selesai)
                    ->where('file_scan', $peminjaman->file_scan)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->update(['status' => 3]); // Status selesai
            }
        }
        $laporan = Pelaporan::create([
            'id_logistik' => $request->id_logistik,
            'id_mahasiswa' => $mahasiswaId,
            'id_ruangan' => $peminjaman->id_ruangan,
            'id_pinjam_ruangan' => $request->id_peminjaman,
            'datetime' => $request->datetime,
            'foto_awal' => $fotoAwalPath,
            'foto_akhir' => $fotoAkhirPath,
            'deskripsi' => $request->deskripsi,
            'oleh' => Session::get('mahasiswa_name'),
            'kepada' => 'Admin Logistik'
        ]);
        
        return redirect()->route('mahasiswa.pelaporan.lapor_ruangan.index')
            ->with('success', 'Laporan berhasil dikirim dan peminjaman ditandai selesai.');
    }

    public function mahasiswaEdit($id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = Pelaporan::where('id_lapor_ruangan', $id)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->first();
                    
        if (!$laporan) {
            return redirect()->route('mahasiswa.pelaporan.lapor_ruangan.index')
                ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }
        

        $ruangan = \App\Models\Ruangan::all();
        
        return view('mahasiswa.pelaporan.lapor_ruangan.edit', compact('laporan', 'ruangan'));
    }
    public function mahasiswaUpdate(Request $request, $id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = Pelaporan::where('id_lapor_ruangan', $id)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->first();
                    
        if (!$laporan) {
            return redirect()->route('mahasiswa.pelaporan.lapor_ruangan.index')
                ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }
        
        $request->validate([
            'deskripsi' => 'required|string',
            'foto_awal' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_akhir' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        

        if ($request->hasFile('foto_awal')) {

            if ($laporan->foto_awal) {
                Storage::disk('public')->delete($laporan->foto_awal);
            }
            
            $fotoAwal = $request->file('foto_awal');
            $fotoAwalFilename = time() . '_awal_' . $fotoAwal->getClientOriginalName();
            $laporan->foto_awal = $fotoAwal->storeAs('foto_laporan', $fotoAwalFilename, 'public');
        }
        

        if ($request->hasFile('foto_akhir')) {

            if ($laporan->foto_akhir) {
                Storage::disk('public')->delete($laporan->foto_akhir);
            }
            
            $fotoAkhir = $request->file('foto_akhir');
            $fotoAkhirFilename = time() . '_akhir_' . $fotoAkhir->getClientOriginalName();
            $laporan->foto_akhir = $fotoAkhir->storeAs('foto_laporan', $fotoAkhirFilename, 'public');
        }
        
        $laporan->deskripsi = $request->deskripsi;
        $laporan->save();
        
        return redirect()->route('mahasiswa.pelaporan.lapor_ruangan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function mahasiswaShow($id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporan = Pelaporan::where('id_lapor_ruangan', $id)
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->with('logistik', 'ruangan', 'peminjaman')
                    ->first();
                    
        if (!$laporan) {
            return redirect()->route('mahasiswa.pelaporan.lapor_ruangan.index')
                ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
        }
        
        return view('mahasiswa.pelaporan.lapor_ruangan.show', compact('laporan'));
    }
}