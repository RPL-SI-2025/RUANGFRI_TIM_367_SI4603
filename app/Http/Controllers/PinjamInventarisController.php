<?php

namespace App\Http\Controllers;

use App\Models\PinjamInventaris;
use App\Models\Inventaris;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class PinjamInventarisController extends Controller
{

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


    public function create()
    {
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Keranjang Anda kosong!');
        }
        
        return view('mahasiswa.peminjaman.pinjam_inventaris.create', compact('cartItems'));
    }


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
        
        // Cek ketersediaan stok sebelum menyimpan
        foreach ($cartItems as $item) {
            $inventaris = \App\Models\Inventaris::find($item['id']);
            if (!$inventaris || $inventaris->jumlah < $item['jumlah']) {
                return redirect()->back()->with('error', "Stok {$item['nama_inventaris']} tidak mencukupi. Stok tersedia: {$inventaris->jumlah}");
            }
        }

        DB::beginTransaction();
        
        try {
            $fileName = null;
            if ($request->hasFile('file_scan')) {
                $file = $request->file('file_scan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/file_scan', $fileName, 'public');
            }
            
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
                    'status' => 0 
                ]);
                
                // Kurangi stok inventaris ketika peminjaman dibuat (status proses)
                $inventaris = \App\Models\Inventaris::find($item['id']);
                $inventaris->jumlah -= $item['jumlah'];
                
                // Update status inventaris jika stok habis
                if ($inventaris->jumlah <= 0) {
                    $inventaris->status = 'Tidak Tersedia';
                }
                $inventaris->save();
            }
            
            Session::forget('cart');
            DB::commit();
            
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('success', 'Pengajuan peminjaman inventaris berhasil ditambahkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        

        if (in_array($pinjamInventaris->status, [1, 3])) {
            return redirect()->route('pinjam-inventaris.mahasiswa')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diedit.');
        }


        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'inventaris' => 'required|array',
            'inventaris.*.jumlah' => 'required|integer|min:1'
        ]);

        
        $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
            ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
            ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
            ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
            ->where('file_scan', $pinjamInventaris->file_scan)
            ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
            ->get();

        DB::beginTransaction();
        
        try {
            // Validasi stok untuk setiap perubahan kuantitas
            if ($request->has('inventaris')) {
                foreach ($request->inventaris as $id => $data) {
                    $pinjamItem = PinjamInventaris::find($id);
                    if ($pinjamItem && $pinjamItem->id_mahasiswa == $mahasiswaId) {
                        $inventaris = \App\Models\Inventaris::find($pinjamItem->id_inventaris);
                        if (!$inventaris) {
                            throw new \Exception("Inventaris dengan ID {$pinjamItem->id_inventaris} tidak ditemukan.");
                        }
                        
                        $oldQuantity = $pinjamItem->jumlah_pinjam;
                        $newQuantity = $data['jumlah'];
                        $quantityDiff = $newQuantity - $oldQuantity;
                        
                        // Jika kuantitas bertambah, cek apakah stok mencukupi
                        if ($quantityDiff > 0) {
                            if ($inventaris->jumlah < $quantityDiff) {
                                throw new \Exception("Stok {$inventaris->nama_inventaris} tidak mencukupi. Stok tersedia: {$inventaris->jumlah}, diperlukan tambahan: {$quantityDiff}");
                            }
                        }
                    }
                }
            }

            $fileName = $pinjamInventaris->file_scan;
            if ($request->hasFile('file_scan')) {
                if ($pinjamInventaris->file_scan) {
                    Storage::disk('public')->delete('uploads/file_scan/' . $pinjamInventaris->file_scan);
                }
                $file = $request->file('file_scan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('uploads/file_scan', $fileName, 'public');
            }
            
            // Update data peminjaman untuk semua item terkait
            foreach ($relatedItems as $item) {
                $item->tanggal_pengajuan = $request->tanggal_pengajuan;
                $item->tanggal_selesai = $request->tanggal_selesai;
                $item->waktu_mulai = $request->waktu_mulai;
                $item->waktu_selesai = $request->waktu_selesai;
                $item->file_scan = $fileName;
                $item->save();
            }
            
            // Update kuantitas dan kelola stok inventaris
            if ($request->has('inventaris')) {
                foreach ($request->inventaris as $id => $data) {
                    $pinjamItem = PinjamInventaris::find($id);
                    if ($pinjamItem && $pinjamItem->id_mahasiswa == $mahasiswaId) {
                        $inventaris = \App\Models\Inventaris::find($pinjamItem->id_inventaris);
                        
                        if ($inventaris) {
                            $oldQuantity = $pinjamItem->jumlah_pinjam;
                            $newQuantity = $data['jumlah'];
                            $quantityDiff = $newQuantity - $oldQuantity;
                            
                            // Update kuantitas peminjaman
                            $pinjamItem->jumlah_pinjam = $newQuantity;
                            $pinjamItem->save();
                            
                            // Update stok inventaris berdasarkan perubahan kuantitas
                            if ($quantityDiff != 0) {
                                // Jika kuantitas bertambah, kurangi stok
                                // Jika kuantitas berkurang, tambah stok
                                $inventaris->jumlah -= $quantityDiff;
                                
                                // Update status inventaris
                                if ($inventaris->jumlah <= 0) {
                                    $inventaris->status = 'Tidak Tersedia';
                                } elseif ($inventaris->status == 'Tidak Tersedia' && $inventaris->jumlah > 0) {
                                    $inventaris->status = 'Tersedia';
                                }
                                
                                $inventaris->save();
                            }
                        }
                    }
                }
            }
            
            DB::commit();
            
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('success', 'Pengajuan peminjaman berhasil diperbarui.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    } 


    
    public function updateStatus(Request $request, PinjamInventaris $pinjamInventaris)
    {
        
        $request->validate([
            'status' => 'required|integer|min:0|max:3',
            'notes' => 'nullable|string|max:500', 
        ]);
        
        $oldStatus = $pinjamInventaris->status;
        $newStatus = $request->status;
        
        DB::beginTransaction();
        
        try {
            $pinjamInventaris->status = $newStatus;
        
            if ($request->filled('notes')) {
                $pinjamInventaris->notes = $request->notes;
            }
            
            $pinjamInventaris->save();
            
            // Get all related items
            $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
                ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
                ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
                ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
                ->where('file_scan', $pinjamInventaris->file_scan)
                ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
                ->get();
            
            // Update status untuk semua item terkait
            foreach ($relatedItems as $item) {
                $item->status = $newStatus;
                if ($request->filled('notes')) {
                    $item->notes = $request->notes;
                }
                $item->save();
            }
            
            // Handle inventory stock based on status change
            $this->handleInventoryStock($relatedItems, $oldStatus, $newStatus);
            
            DB::commit();
            
            $statusText = match($newStatus) {
                0 => 'menunggu persetujuan',
                1 => 'disetujui',
                2 => 'ditolak',
                3 => 'selesai',
                default => 'diperbarui'
            };
            
            return back()->with('success', "Status peminjaman berhasil $statusText.");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function adminIndex()
    {
        $peminjaman = PinjamInventaris::with(['inventaris', 'mahasiswa'])
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
                        
        return view('admin.pinjam_inventaris.index', compact('paginatedGroupedPeminjaman'));
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


    public function destroy(PinjamInventaris $pinjamInventaris)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        

        if (!$mahasiswaId || $pinjamInventaris->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini.');
        }
        

        if (in_array($pinjamInventaris->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat dibatalkan.');
        }
        
        DB::beginTransaction();
        
        try {
            // Get all related items before canceling
            $relatedItems = PinjamInventaris::where('tanggal_pengajuan', $pinjamInventaris->tanggal_pengajuan)
                ->where('tanggal_selesai', $pinjamInventaris->tanggal_selesai)
                ->where('waktu_mulai', $pinjamInventaris->waktu_mulai)
                ->where('waktu_selesai', $pinjamInventaris->waktu_selesai)
                ->where('file_scan', $pinjamInventaris->file_scan)
                ->where('id_mahasiswa', $pinjamInventaris->id_mahasiswa)
                ->get();
            
            $oldStatus = $pinjamInventaris->status;
            
            // Update status to canceled
            foreach ($relatedItems as $item) {
                $item->status = 4; // Dibatalkan
                $item->save();
            }
            
            // Return inventory stock when canceled
            $this->handleInventoryStock($relatedItems, $oldStatus, 4);
            
            DB::commit();
            
            return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.index')
                ->with('success', 'Peminjaman berhasil dibatalkan.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    private function handleInventoryStock($relatedItems, $oldStatus, $newStatus)
    {
        foreach ($relatedItems as $item) {
            $inventaris = \App\Models\Inventaris::find($item->id_inventaris);
            
            if (!$inventaris) continue;
            
            // Logic untuk mengembalikan stok jika status berubah dari proses/disetujui ke ditolak/selesai/dibatalkan
            if (in_array($oldStatus, [0, 1]) && in_array($newStatus, [2, 3, 4])) {
                // Kembalikan stok
                $inventaris->jumlah += $item->jumlah_pinjam;
                
                // Update status inventaris menjadi tersedia jika sebelumnya tidak tersedia
                if ($inventaris->status == 'Tidak Tersedia' && $inventaris->jumlah > 0) {
                    $inventaris->status = 'Tersedia';
                }
            }
            // Logic untuk mengurangi stok jika status berubah dari ditolak/dibatalkan ke proses/disetujui
            elseif (in_array($oldStatus, [2, 4]) && in_array($newStatus, [0, 1])) {
                // Cek apakah stok mencukupi
                if ($inventaris->jumlah >= $item->jumlah_pinjam) {
                    $inventaris->jumlah -= $item->jumlah_pinjam;
                    
                    // Update status inventaris jika stok habis
                    if ($inventaris->jumlah <= 0) {
                        $inventaris->status = 'Tidak Tersedia';
                    }
                } else {
                    throw new \Exception("Stok {$inventaris->nama_inventaris} tidak mencukupi untuk mengubah status.");
                }
            }
            
            $inventaris->save();
        }
    }
}