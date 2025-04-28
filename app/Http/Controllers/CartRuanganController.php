<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartRuanganController extends Controller
{
    // Display items in the cart
    public function index()
    {
        $cartItems = Session::get('cart_ruangan', []);
        return view('mahasiswa.cart.indexRuangan', compact('cartItems'));
    }

    // Add item (ruangan) to the cart
    public function add(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $ruangan = Ruangan::findOrFail($request->id_ruangan);

        // Validate if the requested quantity is available
        if ($ruangan->kapasitas < $request->jumlah) {
            return redirect()->back()->with('error', 'Jumlah yang diminta melebihi kapasitas yang tersedia.');
        }

        $cart = Session::get('cart_ruangan', []);
        $itemId = $ruangan->id;
        $newQuantity = $request->jumlah;

        // Check if the item already exists in the cart
        if (isset($cart[$itemId])) {
            $newQuantity += $cart[$itemId]['jumlah'];

            if ($newQuantity > $ruangan->kapasitas) {
                return redirect()->back()->with('error', 'Jumlah total yang diminta melebihi kapasitas yang tersedia.');
            }
        }

        // Store all the necessary data in an associative array
        $itemData = [
            'id' => $ruangan->id,
            'nama_ruangan' => $ruangan->nama_ruangan,
            // 'jumlah' => $newQuantity,
            'kapasitas' => $ruangan->kapasitas,
            'fasilitas' => $ruangan->fasilitas,
            'lokasi' => $ruangan->lokasi,
            'status' => $ruangan->status,
            'gambar' => $ruangan->gambar,
            'timestamp' => now()->toDateTimeString(),
        ];

        // Add or update the item in the cart
        $cart[$itemId] = $itemData;

        // Update the cart session
        Session::put('cart_ruangan', $cart);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan ke keranjang!');
    }

    // public function add(Request $request)
    // {

    //     $request->validate([
    //         'id_ruangan' => 'required|exists:ruangan,id',
    //         'jumlah' => 'required|integer|min:1'
    //     ]);

    //     $ruangan = Ruangan::findOrFail($request->id_ruangan);

    //     if ($ruangan->jumlah < $request->jumlah) {
    //         return redirect()->back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
    //     }

    //     $cart = Session::get('cart', []);

    //     // Iki buat ngecek apa barang yang mau ditambah udah ada di cart apa durung
    //     $itemId = $ruangan->id;
    //     $newQuantity = $request->jumlah;

    //     if (isset($cart[$itemId])) {

    //         $newQuantity = $cart[$itemId]['jumlah'] + $request->jumlah;


    //         if ($newQuantity > $ruangan->jumlah) {
    //             return redirect()->back()->with('error', 'Total jumlah yang diminta melebihi stok yang tersedia.');
    //         }
    //     }

    //     // Simpan semua data yang dibutuhkan dalam dictionary
    //     $itemData = [
    //         'id' => $ruangan->id,
    //         'nama_ruangan' => $ruangan->nama_ruangan,
    //         'jumlah' => $newQuantity,
    //         'kode_ruangan' => $ruangan->kode_ruangan,
    //         'kategori_id' => $ruangan->kategori_id,
    //         'kategori_nama' => $ruangan->kategori->nama_kategori ?? null,
    //         'kondisi' => $ruangan->kondisi,
    //         'stok_tersedia' => $ruangan->jumlah,
    //         'gambar' => $ruangan->gambar,
    //         'timestamp' => now()->toDateTimeString(),
    //     ];

    //     // Update cart dengan data yang lengkap
    //     $cart[$itemId] = $itemData;


    //     Session::put('cart', $cart);

    //     return redirect()->route('mahasiswa.katalog.ruangan.index')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    // }



    // Remove item (ruangan) from the cart
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

    // Clear the entire cart
    public function clear()
    {
        Session::forget('cart_ruangan');
        return redirect()->back()->with('success', 'Keranjang ruangan berhasil dikosongkan.');
    }

    // Checkout the items in the cart
    public function checkout()
    {
        $cartItems = Session::get('cart_ruangan', []);

        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong.');
        }

        // Here you can implement your logic for the actual checkout process (e.g., create booking/reservation)
        // For example, process the booking and clear the cart:

        // Clear the cart after checkout
        Session::forget('cart_ruangan');

        return redirect()->back()->with('success', 'Checkout berhasil! Ruangan telah dipesan.');
    }

    // Update the quantity of a specific item in the cart
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

            // Update the quantity of the item in the cart
            $cart[$id]['jumlah'] = $request->jumlah;
            Session::put('cart_ruangan', $cart);

            return redirect()->back()->with('success', 'Jumlah item berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan di keranjang.');
    }
}
