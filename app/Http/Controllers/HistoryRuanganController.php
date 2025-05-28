<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelaporan;
use App\Models\PinjamRuangan;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryRuanganController extends Controller
{
    public function index()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporanRuangan = Pelaporan::where('id_mahasiswa', $mahasiswaId)
            ->with(['peminjaman' => function($query) {
                $query->where('status', 3); 
            }, 'logistik'])
            ->whereHas('peminjaman', function($query) {
                $query->where('status', 3); 
            })
            ->latest('datetime')
            ->get();
            

        $perPage = 7; 
        $currentPageRuangan = request()->query('page_ruangan', 1);
        
        $paginatedRuangan = new LengthAwarePaginator(
            $laporanRuangan->forPage($currentPageRuangan, $perPage),
            $laporanRuangan->count(),
            $perPage,
            $currentPageRuangan,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page_ruangan']
        );
         
        return view('mahasiswa.history.history_ruangan.index', compact('paginatedRuangan'));
    }
    
    public function show($type, $id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        if ($type === 'ruangan') {
            $laporan = Pelaporan::where('id_lapor_ruangan', $id)
                ->where('id_mahasiswa', $mahasiswaId)
                ->whereHas('peminjaman', function($query) {
                    $query->where('status', 3); 
                })
                ->with(['logistik', 'peminjaman', 'mahasiswa'])
                ->first();
                
            if (!$laporan) {
                return redirect()->route('mahasiswa.history.history_ruangan.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }
            
            
            $relatedItems = PinjamRuangan::where('tanggal_pengajuan', $laporan->peminjaman->tanggal_pengajuan)
                ->where('tanggal_selesai', $laporan->peminjaman->tanggal_selesai)
                ->where('waktu_mulai', $laporan->peminjaman->waktu_mulai)
                ->where('waktu_selesai', $laporan->peminjaman->waktu_selesai)
                ->where('file_scan', $laporan->peminjaman->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->with('ruangan')
                ->get();
            
            return view('mahasiswa.history.history_ruangan.show', compact('laporan', 'relatedItems'));
        
        } elseif ($type === 'ruangan') {}
        
        return redirect()->route('mahasiswa.history.history_ruangan.index')
            ->with('error', 'Tipe laporan tidak valid.');
            
    }
        public function adminindex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        
        $laporanRuangan = Pelaporan::where('id_mahasiswa', $mahasiswaId)
            ->with(['peminjaman' => function($query) {
                $query->where('status', 3); 
            }, 'logistik'])
            ->whereHas('peminjaman', function($query) {
                $query->where('status', 3); 
            })
            ->latest('datetime')
            ->get();
            

        $perPage = 7; 
        $currentPageRuangan = request()->query('page_ruangan', 1);
        
        $paginatedRuangan = new LengthAwarePaginator(
            $laporanRuangan->forPage($currentPageRuangan, $perPage),
            $laporanRuangan->count(),
            $perPage,
            $currentPageRuangan,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page_ruangan']
        );
         
        return view('admin.history_ruangan.index', compact('paginatedRuangan'));
    }
    
    public function adminshow($type, $id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
      
        
        if ($type === 'ruangan') {
            $laporan = Pelaporan::where('id_lapor_ruangan', $id)
                ->where('id_mahasiswa', $mahasiswaId)
                ->whereHas('peminjaman', function($query) {
                    $query->where('status', 3); 
                })
                ->with(['logistik', 'peminjaman', 'mahasiswa'])
                ->first();
                
            if (!$laporan) {
                return redirect()->route('admin.history_ruangan.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }
            
            
            $relatedItems = PinjamRuangan::where('tanggal_pengajuan', $laporan->peminjaman->tanggal_pengajuan)
                ->where('tanggal_selesai', $laporan->peminjaman->tanggal_selesai)
                ->where('waktu_mulai', $laporan->peminjaman->waktu_mulai)
                ->where('waktu_selesai', $laporan->peminjaman->waktu_selesai)
                ->where('file_scan', $laporan->peminjaman->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->with('ruangan')
                ->get();
            
            return view('admin.history_ruangan.show', compact('laporan', 'relatedItems'));
        
        } elseif ($type === 'ruangan') {}
        
        return redirect()->route('admin.history_ruangan.index')
            ->with('error', 'Tipe laporan tidak valid.');
    }
}
