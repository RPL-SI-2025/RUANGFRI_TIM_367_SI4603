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
        
        $pinjamInventaris = PinjamInventaris::with('inventaris')
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->latest()
                    ->paginate(10);
                    
        return view('mahasiswa.peminjaman.pinjam_inventaris.index', compact('pinjamInventaris'));
    }
    
    // Permintaan peminjaman inventaris untuk mahasiswa
    public function mahasiswaPinjaman()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $pinjamInventaris = PinjamInventaris::with('inventaris')
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->latest()
                    ->paginate(10);
                    
        return view('mahasiswa.peminjaman.pinjam_inventaris.index', compact('pinjamInventaris'));
    }

    // Buat formulir permintaan pinjaman baru
    public function create()
    {
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Keranjang Anda kosong!');
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
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Keranjang Anda kosong!');
        }
        
        // Handle file upload once for all items
        $fileName = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/file_scan', $fileName, 'public');
        }
        
        // menambahkan peminjaman inventaris
        foreach ($cartItems as $item) {

            PinjamInventaris::create([
                'id_inventaris' => $item['id'],
                'jumlah_pinjam' => $item['jumlah'],
                'id_mahasiswa' => $mahasiswaId,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'file_scan' => $fileName,
                'status' => 0 // Waiting for approval
            ]);
        }
        
        // Clear cart after successful submission
        Session::forget('cart');
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
            ->with('success', 'Pengajuan peminjaman inventaris berhasil ditambahkan.');
    }

 
    public function show(PinjamInventaris $pinjamInventaris)
{
    $mahasiswaId = Session::get('mahasiswa_id');
    
    if ($pinjamInventaris->id_mahasiswa != $mahasiswaId) {
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
            ->with('error', 'Anda tidak diizinkan melihat peminjaman ini.');
    }
    
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
        'inventaris' => 'required|array',
        'inventaris.*.jumlah' => 'required|integer|min:1',
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
    
    // Update quantity for each related item
    if ($request->has('inventaris')) {
        foreach ($request->inventaris as $id => $data) {
            $pinjamItem = PinjamInventaris::find($id);
            if ($pinjamItem && $pinjamItem->id_mahasiswa == $mahasiswaId) {
                $pinjamItem->jumlah_pinjam = $data['jumlah'];
                $pinjamItem->save();
            }
        }
    }
    
    return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
        ->with('success', 'Pengajuan peminjaman berhasil diperbarui.');
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
                        ->get();
                        
        // Group peminjaman by tanggal_pengajuan, tanggal_selesai, waktu_mulai, waktu_selesai, file_scan, and id_mahasiswa
        $groupedPeminjaman = $peminjaman->groupBy(function($item) {
            return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                  $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
        });
        
        // Convert to paginated collection
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
                        
        return view('admin.pinjam_inventaris.index', compact('paginatedGroupedPeminjaman'));
    }
    
    public function adminApproval()
    {
        $pendingRequests = PinjamInventaris::with(['inventaris', 'mahasiswa'])
                ->where('status', 0)
                ->latest()
                ->get();
                
        // Group pending requests by the same criteria
        $groupedPending = $pendingRequests->groupBy(function($item) {
            return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' . 
                  $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan . '-' . $item->id_mahasiswa;
        });
        
        // Convert to paginated collection
        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $groupedPending->forPage($currentPage, $perPage);
        
        $paginatedGroupedPending = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $groupedPending->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
                
        return view('admin.pinjam_inventaris.admin_approval', compact('paginatedGroupedPending'));
    }

    public function adminShow(PinjamInventaris $pinjamInventaris)
{
    $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
        ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
        ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
        ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
        ->where('file_scan', $pinjamInventaris->file_scan)
        ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
        ->with(['inventaris', 'mahasiswa'])
        ->get();
        
    return view('admin.pinjam_inventaris.show', compact('pinjamInventaris', 'relatedItems'));
}

    // Add this method to your PinjamInventarisController class
    public function destroy(PinjamInventaris $pinjamInventaris)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        // Check if the authenticated user owns this request
        if (!$mahasiswaId || $pinjamInventaris->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini.');
        }
        
        // Check if the status is already approved or completed
        if (in_array($pinjamInventaris->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat dibatalkan.');
        }
        
        // Update status to cancelled (let's use status 4 for cancelled)
        $pinjamInventaris->status = 4;
        $pinjamInventaris->save();
        
        // Find and update all related items with the same details
        PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
            ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
            ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
            ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
            ->where('file_scan', $pinjamInventaris->file_scan)
            ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
            ->update(['status' => 4]);
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
            ->with('success', 'Peminjaman berhasil dibatalkan.');
    }

}