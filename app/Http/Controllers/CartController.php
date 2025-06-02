<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PinjamInventaris;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Session::get('cart', []);
        return view('mahasiswa.cart.keranjang_inventaris.index', compact('cartItems'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'id_inventaris' => 'required|exists:inventaris,id',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $inventaris = Inventaris::with('kategori')->findOrFail($request->id_inventaris);

        
        if ($inventaris->status !== 'Tersedia') {
            return redirect()->back()->with('error', 'Inventaris ini sedang tidak tersedia.');
        }
        
        $cart = Session::get('cart', []);
        $itemId = $inventaris->id;
        $newQuantity = $request->jumlah;
        
        if (isset($cart[$itemId])) {
            $newQuantity = $cart[$itemId]['jumlah'] + $request->jumlah;
        }


        $reservedStock = PinjamInventaris::where('id_inventaris', $itemId)
            ->whereIn('status', [0, 1])   
            ->sum('jumlah_pinjam');
        
        $availableStock = $inventaris->jumlah;



        if ($newQuantity > $availableStock) {
            return redirect()->back()->with('error', 'Total jumlah yang diminta melebihi stok yang tersedia. Stok tersedia: ' . $availableStock);
        }

        $itemData = [
            'id' => $inventaris->id,
            'nama_inventaris' => $inventaris->nama_inventaris,
            'jumlah' => $newQuantity,
            'kode_inventaris' => $inventaris->kode_inventaris,
            'kategori_id' => $inventaris->kategori_id,
            'kategori_nama' => $inventaris->kategori->nama_kategori ?? null,
            'deskripsi' => $inventaris->deskripsi,
            'kondisi' => $inventaris->kondisi,
            'stok_tersedia' => $availableStock,
            'gambar' => $inventaris->gambar,
            'timestamp' => now()->toDateTimeString(),
        ];

        $cart[$itemId] = $itemData;
        Session::put('cart', $cart);
        
        return redirect()->route('mahasiswa.katalog.inventaris.index')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }
    
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('mahasiswa.cart.keranjang_inventaris.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('mahasiswa.cart.keranjang_inventaris.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
    
    public function checkout()
    {
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_inventaris.index')->with('error', 'Keranjang Anda kosong.');
        }
        
        return redirect()->route('mahasiswa.peminjaman.pinjam-inventaris.create');
    }

   public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        

        if(isset($cart[$id])) {
            $inventaris = Inventaris::findOrFail($id);



            $reservedStock = PinjamInventaris::where('id_inventaris', $id)
                ->whereIn('status', [0, 1])   
                ->sum('jumlah_pinjam');
            

            $availableStock = $inventaris->jumlah;

            if ($request->jumlah > $availableStock) {
                return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia. Stok tersedia: ' . $availableStock);
            }
            
            $cart[$id]['jumlah'] = $request->jumlah;
            $cart[$id]['stok_tersedia'] = $availableStock;
            Session::put('cart', $cart);
            
            return redirect()->route('mahasiswa.cart.keranjang_inventaris.index')->with('success', 'Jumlah item berhasil diperbarui.');
        }
        
        return redirect()->route('mahasiswa.cart.keranjang_inventaris.index')->with('error', 'Item tidak ditemukan dalam keranjang.');
    }

}