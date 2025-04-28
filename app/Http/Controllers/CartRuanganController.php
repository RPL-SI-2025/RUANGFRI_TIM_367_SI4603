<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartRuanganController extends Controller
{
    //
    public function index()
    {
        $cartItems = Session::get('cart_ruangan', []);
        return view('mahasiswa.cart.indexRuangan', compact('cartItems'));
    }


    public function add(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
        ]);

        $ruangan = Ruangan::findOrFail($request->id_ruangan);

        if ($ruangan->kapasitas < $request->jumlah) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi kapasitas yang tersedia.');
        }
        // dd($request->all());
        $cart = Session::get('cart_ruangan', []);

        // Check if the item is already in the cart
        $itemId = $ruangan->id;
        $newQuantity = $request->jumlah;

        if (isset($cart[$itemId])) {
            $newQuantity = $cart[$itemId]['jumlah'] + $request->jumlah;

            if ($newQuantity > $ruangan->kapasitas) {
                return redirect()->back()->with('error', 'Total jumlah yang diminta melebihi kapasitas yang tersedia.');
            }
        }

        // Store all necessary data in an associative array
        $itemData = [
            'id' => $ruangan->id,
            'nama_ruangan' => $ruangan->nama_ruangan,
            'jumlah' => $newQuantity,
            'kapasitas' => $ruangan->kapasitas,
            'fasilitas' => $ruangan->fasilitas,
            'lokasi' => $ruangan->lokasi,
            'status' => $ruangan->status,
            'gambar' => $ruangan->gambar,
            'timestamp' => now()->toDateTimeString(),
        ];

        // Add or update the item in the cart
        if (isset($cart[$itemId])) {
            // Update existing item
            $cart[$itemId]['jumlah'] = $newQuantity;
        } else {
            // Add new item to cart
            $cart[$itemId] = $itemData;
        }

        Session::put('cart_ruangan', $cart);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan ke keranjang!');
    }

    public function remove($id)
    {
        $cart = Session::get('cart_ruangan', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart_ruangan', $cart);
            return redirect()->back()->with('success', 'Ruangan berhasil dihapus dari keranjang.');
        }

        return redirect()->back()->with('error', 'Ruangan tidak ditemukan di keranjang.');
    }
    public function clear()
    {
        Session::forget('cart_ruangan');
        return redirect()->back()->with('success', 'Keranjang ruangan berhasil dikosongkan.');
    }
    public function checkout()
    {
        $cartItems = Session::get('cart_ruangan', []);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        // Process the checkout logic here
        // ...

        // Clear the cart after checkout
        Session::forget('cart_ruangan');

        return redirect()->back()->with('success', 'Checkout berhasil! Ruangan telah dipesan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart_ruangan', []);

        if (isset($cart[$id])) {
            $ruangan = Ruangan::findOrFail($id);

            if ($request->jumlah > $ruangan->kapasitas) {
                return redirect()->back()->with('error', 'Jumlah yang diminta melebihi kapasitas yang tersedia.');
            }

            $cart[$id]['jumlah'] = $request->jumlah;
            Session::put('cart_ruangan', $cart);

            return redirect()->back()->with('success', 'Jumlah item berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
    }


}
