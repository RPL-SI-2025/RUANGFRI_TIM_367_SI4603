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
    public function index()
    {
        // admin piye: ngeli semua peminjaman
        $peminjaman = PinjamInventaris::with(['inventaris', 'mahasiswa'])->latest()->paginate(10);
        return view('pinjam_inventaris.index', compact('peminjaman'));
    }
    
    public function mahasiswaPinjaman()
    {
        // mahasiwa piye : ngeli peminjaman yang dia buat
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Account not linked to any student record');
        }
        
        $peminjaman = PinjamInventaris::with('inventaris')
                    ->where('id_mahasiswa', $mahasiswa->id)
                    ->latest()
                    ->paginate(10);
                    
        return view('pinjam_inventaris.mahasiswa_index', compact('peminjaman'));
    }

    public function create()
    {

        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        return view('pinjam_inventaris.create', compact('cartItems'));
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

        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('email', $user->email)->first();
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Account not linked to any student record');
        }
        
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        // menangani file upload
        $fileName = null;
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/file_scan', $fileName, 'public');
        }
        
        // Simpan data peminjaman ke database
        foreach ($cartItems as $item) {
            PinjamInventaris::create([
                'id_inventaris' => $item['id'],
                'id_mahasiswa' => $mahasiswa->id,
                'tanggal_pengajuan' => $request->tanggal_pengajuan,
                'tanggal_selesai' => $request->tanggal_selesai,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'file_scan' => $fileName,
                'status' => 0 // tandanye menunggu persetujuan
            ]);
        }
        
        // menghapus cart setelah peminjaman
        Session::forget('cart');
        
        return redirect()->route('pinjam-inventaris.mahasiswa')
            ->with('success', 'Pengajuan peminjaman inventaris berhasil ditambahkan.');
    }

    public function show(PinjamInventaris $pinjamInventaris)
    {
        return view('pinjam_inventaris.show', compact('pinjamInventaris'));
    }

    public function updateStatus(Request $request, PinjamInventaris $pinjamInventaris)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:3',
        ]);
        
        $pinjamInventaris->status = $request->status;
        $pinjamInventaris->save();
        
        return redirect()->route('pinjam-inventaris.index')
            ->with('success', 'Status peminjaman inventaris berhasil diperbarui.');
    }
    
    // interface admin untuk ngeli peminjaman yang pending
    public function adminApproval()
    {
        $pending = PinjamInventaris::with(['inventaris', 'mahasiswa'])
                ->where('status', 0)
                ->latest()
                ->paginate(10);
                
        return view('pinjam_inventaris.admin_approval', compact('pending'));
    }
}