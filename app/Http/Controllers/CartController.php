<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Session::get('cart', []);
        return view('mahasiswa.cart.index', compact('cartItems'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'id_inventaris' => 'required|exists:inventaris,id',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $inventaris = Inventaris::findOrFail($request->id_inventaris);
        
        // Check if there's enough inventory
        if ($inventaris->jumlah < $request->jumlah) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
        }
        
        // Get the current cart
        $cart = Session::get('cart', []);
        
        // If item already in cart, update the quantity
        if (isset($cart[$inventaris->id_inventaris])) {
            $cart[$inventaris->id_inventaris]['jumlah'] += $request->jumlah;
        } else {
            // Add new item to cart
            $cart[$inventaris->id_inventaris] = [
                'id' => $inventaris->id_inventaris,
                'nama_inventaris' => $inventaris->nama_inventaris,
                'jumlah' => $request->jumlah
            ];
        }
        
        // Update the cart in session
        Session::put('cart', $cart);
        
        return redirect()->route('mahasiswa.inventaris.index')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }
    
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan.');
    }
    
    public function checkout()
    {
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }
        
        return redirect()->route('pinjam-inventaris.create');
    }
}