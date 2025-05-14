<?php

namespace App\Http\Controllers;

use App\Models\PinjamRuangan;
use App\Models\Ruangan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PinjamRuanganController extends Controller
{

    public function mahasiswaIndex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $pinjamRuangan = PinjamRuangan::with('ruangan')
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->latest()
                    ->paginate(10);
                    
        return view('mahasiswa.peminjaman.pinjam_ruangan.index', compact('pinjamRuangan'));
    }
    

    public function create()
    {
        $cartItems = Session::get('cart_ruangan', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Keranjang ruangan Anda kosong!');
        }
        
        return view('mahasiswa.peminjaman.pinjam_ruangan.create', compact('cartItems'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tujuan_peminjaman' => 'required|string',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $cartItems = Session::get('cart_ruangan', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')
                ->with('error', 'Keranjang ruangan Anda kosong!');
        }
        

        $fileName = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/file_scan', $fileName, 'public');
        }
        

        foreach ($cartItems as $key => $item) {
            PinjamRuangan::create([
                'id_ruangan' => $item['id'],
                'id_mahasiswa' => $mahasiswaId,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'tujuan_peminjaman' => $request->tujuan_peminjaman,
                'file_scan' => $fileName,
                'status' => 0 // Menunggu persetujuan
            ]);
        }
        

        Session::forget('cart_ruangan');
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
            ->with('success', 'Pengajuan peminjaman ruangan berhasil ditambahkan.');
    }


    public function show(PinjamRuangan $pinjamRuangan)
        {
            $mahasiswaId = Session::get('mahasiswa_id');
            
            if ($pinjamRuangan->id_mahasiswa != $mahasiswaId) {
                return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                    ->with('error', 'Anda tidak diizinkan melihat peminjaman ini.');
            }
            

            $relatedRooms = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                ->where('file_scan', $pinjamRuangan->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->with('ruangan')
                ->get();
            
            return view('mahasiswa.peminjaman.pinjam_ruangan.show', compact('pinjamRuangan', 'relatedRooms'));
        }


    public function edit(PinjamRuangan $pinjamRuangan)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId || $pinjamRuangan->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit peminjaman ini.');
        }
        

        if (in_array($pinjamRuangan->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diedit.');
        }
        

        $relatedBookings = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
            ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
            ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
            ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
            ->where('file_scan', $pinjamRuangan->file_scan)
            ->where('id_mahasiswa', $mahasiswaId)
            ->with('ruangan')
            ->get();
        
        return view('mahasiswa.peminjaman.pinjam_ruangan.edit', compact('pinjamRuangan', 'relatedBookings'));
    }


    public function update(Request $request, PinjamRuangan $pinjamRuangan)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId || $pinjamRuangan->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah peminjaman ini.');
        }
        

        if (in_array($pinjamRuangan->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diubah.');
        }


        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tujuan_peminjaman' => 'required|string',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        


        if ($request->hasFile('file_scan')) {
            if ($pinjamRuangan->file_scan) {
                Storage::disk('public')->delete('uploads/file_scan/' . $pinjamRuangan->file_scan);
            }
            
            $file = $request->file('file_scan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/file_scan', $fileName, 'public');
            
            $pinjamRuangan->file_scan = $fileName;
            
            $pinjamRuangan->save();
        }
        

        $relatedBookings = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
            ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
            ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
            ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
            ->where('file_scan', $pinjamRuangan->file_scan)
            ->where('id_mahasiswa', $mahasiswaId)
            ->get();
        

        foreach ($relatedBookings as $booking) {
            $booking->tanggal_pengajuan = $request->tanggal_pengajuan;
            $booking->tanggal_selesai = $request->tanggal_selesai;
            $booking->waktu_mulai = $request->waktu_mulai;
            $booking->waktu_selesai = $request->waktu_selesai;
            $booking->tujuan_peminjaman = $request->tujuan_peminjaman;
            

            if ($request->hasFile('file_scan')) {
                $booking->file_scan = $fileName;
            }
            
            $booking->save();
        }
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
            ->with('success', 'Pengajuan peminjaman ruangan berhasil diperbarui.');
    }
    

    public function updateStatus(Request $request, PinjamRuangan $pinjamRuangan)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:4',
            'catatan' => 'nullable|string',
        ]);
        

        $pinjamRuangan->status = $request->status;
        

        if ($request->filled('catatan')) {
            $pinjamRuangan->catatan = $request->catatan;
        }
        
        $pinjamRuangan->save();
        
        $statusText = match($request->status) {
            0 => 'menunggu persetujuan',
            1 => 'disetujui',
            2 => 'ditolak',
            3 => 'selesai',
            4 => 'dibatalkan',
            default => 'diperbarui'
        };
        
        return back()->with('success', "Status peminjaman ruangan berhasil $statusText.");
    }
    

    public function adminIndex()
    {
        $peminjaman = PinjamRuangan::with(['ruangan', 'mahasiswa'])
                        ->latest()
                        ->get();
        

        $groupedPeminjaman = $peminjaman->groupBy(function($item) {
            return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                  $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
        });
        

        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $groupedPeminjaman->forPage($currentPage, $perPage);
        
        $paginatedGroupedPeminjaman = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $groupedPeminjaman->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
                        
        return view('admin.pinjam_ruangan.index', compact('paginatedGroupedPeminjaman'));
    }
    

    public function adminShow(PinjamRuangan $pinjamRuangan)
    {
        $relatedItems = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
            ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
            ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
            ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
            ->where('file_scan', $pinjamRuangan->file_scan)
            ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
            ->with(['ruangan', 'mahasiswa'])
            ->get();
            
        return view('admin.pinjam_ruangan.show', compact('pinjamRuangan', 'relatedItems'));
    }


    public function cancel(PinjamRuangan $pinjamRuangan)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        

        if (!$mahasiswaId || $pinjamRuangan->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini.');
        }
        

        if (in_array($pinjamRuangan->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat dibatalkan.');
        }
        

        $pinjamRuangan->status = 4;
        $pinjamRuangan->save();
        

        PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
            ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
            ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
            ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
            ->where('file_scan', $pinjamRuangan->file_scan)
            ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
            ->update(['status' => 4]);
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
            ->with('success', 'Peminjaman ruangan berhasil dibatalkan.');
    }
}