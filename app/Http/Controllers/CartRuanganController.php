<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartRuanganController extends Controller
{
    // Menampilkan daftar isi cart ruangan
    public function index()
    {
        $cartRuangan = Session::get('cart_ruangan', []);
        return view('mahasiswa.cart_ruangan.index', compact('cartRuangan'));
    }

    // Menambahkan ruangan ke cart
    public function add(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $ruangan = Ruangan::findOrFail($request->id_ruangan);

        $cart = Session::get('cart_ruangan', []);
        dd($request->all());
        $itemId = $ruangan->id;

        $itemData = [
            'id' => $ruangan->id,
            'nama_ruangan' => $ruangan->nama_ruangan,
            'lokasi' => $ruangan->lokasi,
            'kapasitas' => $ruangan->kapasitas,
            'fasilitas' => $ruangan->fasilitas,
            'status' => $ruangan->status,
            'gambar' => $ruangan->gambar,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'timestamp' => now()->toDateTimeString(),
        ];

        $cart[$itemId] = $itemData;

        Session::put('cart_ruangan', $cart);

        return redirect()->route('mahasiswa.katalog.ruangan.index')->with('success', 'Ruangan berhasil ditambahkan ke keranjang.');
    }


    // Menghapus ruangan dari cart
    public function remove($id)
    {
        $cart = Session::get('cart_ruangan', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart_ruangan', $cart);
        }

        return redirect()->route('cart_ruangan.index')->with('success', 'Ruangan berhasil dihapus dari keranjang.');
    }

    // Mengosongkan semua ruangan dari cart
    public function clear()
    {
        Session::forget('cart_ruangan');
        return redirect()->route('cart_ruangan.index')->with('success', 'Keranjang ruangan berhasil dikosongkan.');
    }

    // Proses checkout ruangan
    public function checkout()
    {
        $cartRuangan = Session::get('cart_ruangan', []);

        if (empty($cartRuangan)) {
            return redirect()->route('cart_ruangan.index')->with('error', 'Keranjang ruangan Anda kosong.');
        }

        return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.create');
    }
}
