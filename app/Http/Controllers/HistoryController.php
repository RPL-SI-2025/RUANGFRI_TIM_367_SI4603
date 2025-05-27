<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\laporinventaris;
use App\Models\Pelaporan;
use App\Models\PinjamInventaris;
use App\Models\PinjamRuangan;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;

class HistoryController extends Controller
{
    public function index()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $laporanInventaris = laporinventaris::where('id_mahasiswa', $mahasiswaId)
            ->with(['peminjaman' => function($query) {
                $query->where('status', 3); 
            }, 'logistik'])
            ->whereHas('peminjaman', function($query) {
                $query->where('status', 3); 
            })
            ->latest('datetime')
            ->get();
            

        $perPage = 7; 
        $currentPageInventaris = request()->query('page_inventaris', 1);
        
        $paginatedInventaris = new LengthAwarePaginator(
            $laporanInventaris->forPage($currentPageInventaris, $perPage),
            $laporanInventaris->count(),
            $perPage,
            $currentPageInventaris,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page_inventaris']
        );
         
        return view('mahasiswa.history.history_inventaris.index', compact('paginatedInventaris'));
    }
    
    public function show($type, $id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        if ($type === 'inventaris') {
            $laporan = laporinventaris::where('id_lapor_inventaris', $id)
                ->where('id_mahasiswa', $mahasiswaId)
                ->whereHas('peminjaman', function($query) {
                    $query->where('status', 3); 
                })
                ->with(['logistik', 'peminjaman', 'mahasiswa'])
                ->first();
                
            if (!$laporan) {
                return redirect()->route('mahasiswa.history.history_inventaris.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }
            
            // Get all related inventaris items 
            $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $laporan->peminjaman->tanggal_pengajuan)
                ->where('tanggal_selesai', $laporan->peminjaman->tanggal_selesai)
                ->where('waktu_mulai', $laporan->peminjaman->waktu_mulai)
                ->where('waktu_selesai', $laporan->peminjaman->waktu_selesai)
                ->where('file_scan', $laporan->peminjaman->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->with('inventaris')
                ->get();
            
            return view('mahasiswa.history.history_inventaris.show_inventaris', compact('laporan', 'relatedItems'));
        
        } elseif ($type === 'inventaris') {}
        
        return redirect()->route('mahasiswa.history.history_inventaris.index')
            ->with('error', 'Tipe laporan tidak valid.');
    }
        public function adminindex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        
        $laporanInventaris = laporinventaris::where('id_mahasiswa', $mahasiswaId)
            ->with(['peminjaman' => function($query) {
                $query->where('status', 3); 
            }, 'logistik'])
            ->whereHas('peminjaman', function($query) {
                $query->where('status', 3); 
            })
            ->latest('datetime')
            ->get();
            

        $perPage = 7; 
        $currentPageInventaris = request()->query('page_inventaris', 1);
        
        $paginatedInventaris = new LengthAwarePaginator(
            $laporanInventaris->forPage($currentPageInventaris, $perPage),
            $laporanInventaris->count(),
            $perPage,
            $currentPageInventaris,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'page_inventaris']
        );
         
        return view('admin.history_inventaris.index', compact('paginatedInventaris'));
    }
    
    public function adminshow($type, $id)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
      
        
        if ($type === 'inventaris') {
            $laporan = laporinventaris::where('id_lapor_inventaris', $id)
                ->where('id_mahasiswa', $mahasiswaId)
                ->whereHas('peminjaman', function($query) {
                    $query->where('status', 3); 
                })
                ->with(['logistik', 'peminjaman', 'mahasiswa'])
                ->first();
                
            if (!$laporan) {
                return redirect()->route('admin.history_inventaris.index')
                    ->with('error', 'Laporan tidak ditemukan atau Anda tidak memiliki akses.');
            }
            
            // Get all related inventaris items 
            $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $laporan->peminjaman->tanggal_pengajuan)
                ->where('tanggal_selesai', $laporan->peminjaman->tanggal_selesai)
                ->where('waktu_mulai', $laporan->peminjaman->waktu_mulai)
                ->where('waktu_selesai', $laporan->peminjaman->waktu_selesai)
                ->where('file_scan', $laporan->peminjaman->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->with('inventaris')
                ->get();
            
            return view('admin.history_inventaris.show', compact('laporan', 'relatedItems'));
        
        } elseif ($type === 'inventaris') {}
        
        return redirect()->route('admin.history_inventaris.index')
            ->with('error', 'Tipe laporan tidak valid.');
    }
}
