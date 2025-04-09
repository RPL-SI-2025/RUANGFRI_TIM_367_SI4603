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
        return view('cart.index', compact('cartItems'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'id_inventaris' => 'required|exists:inventaris,id',
            'jumlah' => 'required|integer|min:1'
        ]);
        
        $id = $request->id_inventaris;
        $inventaris = Inventaris::findOrFail($id);
        
        $cart = Session::get('cart', []);
        
        // Check if item already in cart
        if(isset($cart[$id])) {
            $cart[$id]['jumlah'] += $request->jumlah;
        } else {
            $cart[$id] = [
                'id' => $id,
                'nama_inventaris' => $inventaris->nama_inventaris,
                'jumlah' => $request->jumlah
            ];
        }
        
        Session::put('cart', $cart);
        
        return redirect()->back()->with('success', 'Item added to cart successfully!');
    }
    
    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if(isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return redirect()->back()->with('success', 'Item removed from cart!');
    }
    
    public function clear()
    {
        Session::forget('cart');
        return redirect()->back()->with('success', 'Cart cleared!');
    }
    
    public function checkout()
    {
        $cartItems = Session::get('cart', []);
        
        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        return view('cart.checkout', compact('cartItems'));
    }
}