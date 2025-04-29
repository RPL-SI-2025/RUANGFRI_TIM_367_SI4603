<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RuanganCartController extends Controller
{
    public function index()
    {
        $cartRuangan = Session::get('cart_ruangan', []);
        return view('mahasiswa.cart.keranjang_ruangan.index', compact('cartRuangan'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai'
        ]);
        
        $ruangan = Ruangan::findOrFail($request->id_ruangan);
        
        // Check if room is available
        if ($ruangan->status != 'Tersedia') {
            return redirect()->back()->with('error', 'Ruangan tidak tersedia untuk peminjaman.');
        }
        
        $cart = Session::get('cart_ruangan', []);
        
        // Create a unique key for the ruangan booking
        $itemKey = $ruangan->id . '_' . $request->tanggal_booking . '_' . $request->waktu_mulai . '_' . $request->waktu_selesai;
        
        // Check if the same room is already booked for the requested time
        foreach ($cart as $key => $item) {
            if ($item['id'] == $ruangan->id && 
                $item['tanggal_booking'] == $request->tanggal_booking &&
                ($request->waktu_mulai < $item['waktu_selesai'] && $request->waktu_selesai > $item['waktu_mulai'])) {
                return redirect()->back()->with('error', 'Ruangan ini sudah ada dalam keranjang untuk waktu yang sama atau bersinggungan.');
            }
        }
        
        // Prepare item data
        $itemData = [
            'id' => $ruangan->id,
            'nama_ruangan' => $ruangan->nama_ruangan,
            'kapasitas' => $ruangan->kapasitas,
            'lokasi' => $ruangan->lokasi,
            'fasilitas' => $ruangan->fasilitas,
            'gambar' => $ruangan->gambar,
            'tanggal_booking' => $request->tanggal_booking,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'timestamp' => now()->toDateTimeString(),
        ];
        
        // Add to cart
        $cart[$itemKey] = $itemData;
        Session::put('cart_ruangan', $cart);
        
        return redirect()->route('mahasiswa.katalog.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan ke keranjang.');
    }
    
    public function remove($key)
    {
        $cart = Session::get('cart_ruangan', []);
        
        if(isset($cart[$key])) {
            unset($cart[$key]);
            Session::put('cart_ruangan', $cart);
        }
        
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Ruangan berhasil dihapus dari keranjang.');
    }
    
    public function clear()
    {
        Session::forget('cart_ruangan');
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Keranjang ruangan berhasil dikosongkan.');
    }
    
    public function checkout()
    {
        $cartItems = Session::get('cart_ruangan', []);
        // dd($cartItems);
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')
                            ->with('error', 'Keranjang ruangan Anda kosong.');
        }
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.create');
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai'
        ]);
        
        $cart = Session::get('cart_ruangan', []);
        
        if(isset($cart[$key])) {
            $ruanganId = $cart[$key]['id'];
            $ruangan = Ruangan::findOrFail($ruanganId);
            
            if ($ruangan->status != 'Tersedia') {
                return redirect()->back()->with('error', 'Ruangan tidak tersedia untuk peminjaman.');
            }
            
            // Check for time conflicts with other items in cart
            $newKey = $ruanganId . '_' . $request->tanggal_booking . '_' . $request->waktu_mulai . '_' . $request->waktu_selesai;
            
            foreach ($cart as $existingKey => $item) {
                if ($existingKey != $key && $item['id'] == $ruanganId && 
                    $item['tanggal_booking'] == $request->tanggal_booking &&
                    ($request->waktu_mulai < $item['waktu_selesai'] && $request->waktu_selesai > $item['waktu_mulai'])) {
                    return redirect()->back()->with('error', 'Waktu yang dipilih bersinggungan dengan peminjaman lain di keranjang.');
                }
            }
            
            // Remove old item
            $itemData = $cart[$key];
            unset($cart[$key]);
            
            // Update with new data
            $itemData['tanggal_booking'] = $request->tanggal_booking;
            $itemData['waktu_mulai'] = $request->waktu_mulai;
            $itemData['waktu_selesai'] = $request->waktu_selesai;
            $itemData['timestamp'] = now()->toDateTimeString();
            
            // Add back with new key
            $cart[$newKey] = $itemData;
            Session::put('cart_ruangan', $cart);
            
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Peminjaman ruangan berhasil diperbarui.');
        }
        
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Ruangan tidak ditemukan dalam keranjang.');
    }
}