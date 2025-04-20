<?php

namespace App\Http\Controllers;

use App\Models\PinjamInventaris;
use App\Models\Inventaris;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PinjamInventarisController extends Controller
{
    // Permintaan peminjaman inventaris untuk admin
    public function mahasiswaIndex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $peminjaman = PinjamInventaris::with('inventaris')
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->latest()
                    ->paginate(10);
                    
        return view('mahasiswa.peminjaman.pinjam_inventaris.index', compact('peminjaman'));
    }
    
    // Permintaan peminjaman inventaris untuk mahasiswa
    public function mahasiswaPinjaman()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $peminjaman = PinjamInventaris::with('inventaris')
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->latest()
                    ->paginate(10);
                    
        return view('mahasiswa.peminjaman.pinjam_inventaris.index', compact('peminjaman'));
    }

    // Buat formulir permintaan pinjaman baru
    public function create()
    {
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }
        
        return view('mahasiswa.peminjaman.pinjam_inventaris.create', compact('cartItems'));
    }

    // Simpan permintaan pinjaman baru
    public function store(Request $request)
{
        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
        }
        
        // Menangani unggahan file
        $fileName = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/file_scan', $fileName, 'public');
        }
        
        // Simpan pinjaman
        foreach ($cartItems as $item) {
            PinjamInventaris::create([
                'id_inventaris' => $item['id'],
                'id_mahasiswa' => $mahasiswaId,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'file_scan' => $fileName,
                'status' => 0 // Waiting for approval
            ]);
        }
        
        // Kosongkan keranjang setelah pengiriman berhasil
        Session::forget('cart');
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
            ->with('success', 'Pengajuan peminjaman inventaris berhasil ditambahkan.');
    }

    // Show loan request details
    public function show(PinjamInventaris $pinjamInventaris)
    {
        return view('mahasiswa.peminjaman.pinjam_inventaris.show', compact('pinjamInventaris'));
    }

    public function edit(PinjamInventaris $pinjamInventaris)
    {

        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId || $pinjamInventaris->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('pinjam-inventaris.mahasiswa')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit peminjaman ini.');
        }
        

        if (in_array($pinjamInventaris->status, [1, 3])) {
            return redirect()->route('pinjam-inventaris.mahasiswa')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diedit.');
        }
        
        return view('mahasiswa.peminjaman.pinjam_inventaris.edit', compact('pinjamInventaris'));
    }


    public function update(Request $request, PinjamInventaris $pinjamInventaris)
    {

        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId || $pinjamInventaris->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('pinjam-inventaris.mahasiswa')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah peminjaman ini.');
        }
        
        // jikane status peminjaman sudah disetujui atau selesai
        if (in_array($pinjamInventaris->status, [1, 3])) {
            return redirect()->route('pinjam-inventaris.mahasiswa')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diubah.');
        }

        //validasi input
        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        
        // Menangani unggahan file
        // jika ada file baru yang diunggah, hapus file lama
        if ($request->hasFile('file_scan')) {

            if ($pinjamInventaris->file_scan) {
                Storage::disk('public')->delete('uploads/file_scan/' . $pinjamInventaris->file_scan);
            }
            
            $file = $request->file('file_scan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/file_scan', $fileName, 'public');
            
            $pinjamInventaris->file_scan = $fileName;
        }
        
        // Update pinjaman
        $pinjamInventaris->tanggal_pengajuan = $request->tanggal_pengajuan;
        $pinjamInventaris->tanggal_selesai = $request->tanggal_selesai;
        $pinjamInventaris->waktu_mulai = $request->waktu_mulai;
        $pinjamInventaris->waktu_selesai = $request->waktu_selesai;
        $pinjamInventaris->save();
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
            ->with('success', 'Pengajuan peminjaman berhasil diperbarui.');
    }
    public function destroy(PinjamInventaris $pinjamInventaris)
    {
        // Delete file if exists
        if ($pinjamInventaris->file_scan) {
            Storage::disk('public')->delete('uploads/file_scan/' . $pinjamInventaris->file_scan);
        }
        
        $pinjamInventaris->delete();
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
            ->with('success', 'Pengajuan peminjaman berhasil dihapus.');
    }
    
    // Update loan request status
    public function updateStatus(Request $request, PinjamInventaris $pinjamInventaris)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:3',
        ]);
        
        $pinjamInventaris->status = $request->status;
        $pinjamInventaris->save();
        
        $statusText = match($request->status) {
            0 => 'menunggu persetujuan',
            1 => 'disetujui',
            2 => 'ditolak',
            3 => 'selesai',
            default => 'diperbarui'
        };
        
        return back()->with('success', "Status peminjaman berhasil $statusText.");
    }
    
    // Admin approval interface
    public function adminIndex()
    {
        $peminjaman = PinjamInventaris::with(['inventaris', 'mahasiswa'])
                        ->latest()
                        ->paginate(10);
                        
        return view('admin.pinjam_inventaris.index', compact('peminjaman'));
    }
    public function adminApproval()
    {
        $pending = PinjamInventaris::with(['inventaris', 'mahasiswa'])
                ->where('status', 0)
                ->latest()
                ->paginate(10);
                
        return view('admin.pinjam_inventaris.admin_approval', compact('pending'));
    }
    public function adminShow(PinjamInventaris $pinjamInventaris)
    {
        return view('admin.pinjam_inventaris.show', compact('pinjamInventaris'));
    }
    

}