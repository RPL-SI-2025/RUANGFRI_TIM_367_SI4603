<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use App\Models\PinjamRuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;



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
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);
        
        $ruangan = Ruangan::find($request->id_ruangan);
        
        if (!$ruangan || $ruangan->status != 'Tersedia') {
            return redirect()->back()->with('error', 'Ruangan tidak tersedia untuk peminjaman.');
        }
        

        $startTime = Carbon::parse($request->waktu_mulai)->format('H:i:s');
        $endTime = Carbon::parse($request->waktu_selesai)->format('H:i:s');
        

        $jadwals = Jadwal::where('id_ruangan', $request->id_ruangan)
                        ->where('tanggal', $request->tanggal_booking)
                        ->where(function($query) use ($startTime, $endTime) {


                            $query->where(function($q) use ($startTime, $endTime) {

                                $q->where('jam_mulai', '<=', $startTime)
                                ->where('jam_selesai', '>', $startTime);
                            })
                            ->orWhere(function($q) use ($startTime, $endTime) {


                                $q->where('jam_mulai', '<', $endTime)
                                ->where('jam_selesai', '>=', $endTime);
                            })
                            ->orWhere(function($q) use ($startTime, $endTime) {

                                $q->where('jam_mulai', '>=', $startTime)
                                ->where('jam_selesai', '<=', $endTime);
                            });
                        })
                        ->where('status', 'tersedia')
                        ->get();
        
        if ($jadwals->isEmpty()) {
            return redirect()->back()->with('error', 'Jadwal yang dipilih tidak tersedia untuk peminjaman.');
        }
        
        $cart = Session::get('cart_ruangan', []);
        

        $itemKey = $ruangan->id . '_' . $request->tanggal_booking . '_' . $startTime . '_' . $endTime;
        

        foreach ($cart as $key => $item) {
            if ($item['id'] == $ruangan->id && 
                $item['tanggal_booking'] == $request->tanggal_booking &&
                ($startTime < $item['waktu_selesai'] && $endTime > $item['waktu_mulai'])) {
                return redirect()->back()->with('error', 'Ruangan ini sudah ada dalam keranjang untuk waktu yang sama atau bersinggungan.');
            }
        }
        
        $jadwalIds = $jadwals->pluck('id')->toArray();
        

        $selectedSlots = [];
        if ($request->has('selected_slots')) {

            $selectedSlotsJson = $request->selected_slots;
            $decodedSlots = json_decode($selectedSlotsJson, true);
            
            if (is_array($decodedSlots)) {
                $selectedSlots = $decodedSlots;
            }
        }
        
        $itemData = [
            'id' => $ruangan->id,
            'nama_ruangan' => $ruangan->nama_ruangan,
            'kapasitas' => $ruangan->kapasitas,
            'lokasi' => $ruangan->lokasi,
            'deskripsi' => $ruangan->deskripsi,
            'foto' => $ruangan->foto,
            'tanggal_booking' => $request->tanggal_booking,
            'waktu_mulai' => $startTime,
            'waktu_selesai' => $endTime,
            'jadwal_ids' => $jadwalIds,
            'selected_slots' => $selectedSlots,
            'timestamp' => now()->toDateTimeString()
        ];
        

        $cart[$itemKey] = $itemData;
        Session::put('cart_ruangan', $cart);
        
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Ruangan berhasil ditambahkan ke keranjang.');
    }
    
    public function remove($itemKey)
    {
    $cart = Session::get('cart_ruangan', []);
    
    if (isset($cart[$itemKey])) {
        unset($cart[$itemKey]);
        Session::put('cart_ruangan', $cart);
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
    
    return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Item tidak ditemukan dalam keranjang.');
    }
    
    public function clear()
    {
        Session::forget('cart_ruangan');
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Keranjang ruangan berhasil dikosongkan.');
    }
    
    public function checkout()
    {
        $cart = Session::get('cart_ruangan', []);
        
        if (empty($cart)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')
                ->with('error', 'Keranjang ruangan kosong. Tidak dapat melakukan checkout.');
        }
        

        $mahasiswaId = Session::get('mahasiswa_id');
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu untuk melanjutkan peminjaman.');
        }
        

        return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.create');
    }

    public function update(Request $request, $key)
    {
        $request->validate([
            'tanggal_booking' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
        ]);

        $cart = Session::get('cart_ruangan', []);
        
        if (isset($cart[$key])) {
            $ruanganId = $cart[$key]['id'];
            
            $startTime = Carbon::parse($request->waktu_mulai)->format('H:i:s');
            $endTime = Carbon::parse($request->waktu_selesai)->format('H:i:s');
            

            $newKey = $ruanganId . '_' . $request->tanggal_booking . '_' . $startTime . '_' . $endTime;
            

            foreach ($cart as $existingKey => $item) {
                if ($existingKey != $key && $item['id'] == $ruanganId && 
                    $item['tanggal_booking'] == $request->tanggal_booking &&
                    ($startTime < $item['waktu_selesai'] && $endTime > $item['waktu_mulai'])) {
                    return redirect()->back()->with('error', 'Waktu yang dipilih bersinggungan dengan peminjaman lain di keranjang.');
                }
            }
            

            $itemData = $cart[$key];
            unset($cart[$key]);
            

            $itemData['tanggal_booking'] = $request->tanggal_booking;
            $itemData['waktu_mulai'] = $startTime;
            $itemData['waktu_selesai'] = $endTime;
            

            if ($request->has('selected_slots_json')) {
                $itemData['selected_slots'] = json_decode($request->selected_slots_json, true);
            }
            
            $itemData['timestamp'] = now()->toDateTimeString();
            

            $cart[$newKey] = $itemData;
            Session::put('cart_ruangan', $cart);
            
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Peminjaman ruangan berhasil diperbarui.');
        }
        
        return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Ruangan tidak ditemukan dalam keranjang.');
    }
    public function batchSchedule(Request $request)
    {
        $request->validate([
            'use_same_schedule' => 'required|boolean',
            'tanggal_booking' => 'required_if:use_same_schedule,1|date|after_or_equal:today',
            'waktu_mulai' => 'required_if:use_same_schedule,1',
            'waktu_selesai' => 'required_if:use_same_schedule,1|after:waktu_mulai',
            'ruangan_ids' => 'required|array',
            'ruangan_ids.*' => 'exists:ruangan,id'
        ]);
        
        if ($request->use_same_schedule) {

            $startTime = Carbon::parse($request->waktu_mulai)->format('H:i:s');
            $endTime = Carbon::parse($request->waktu_selesai)->format('H:i:s');
            $cart = Session::get('cart_ruangan', []);
            
            foreach ($request->ruangan_ids as $ruanganId) {
                $ruangan = Ruangan::findOrFail($ruanganId);
                
                if ($ruangan->status != 'Tersedia') {
                    return redirect()->back()->with('error', "Ruangan {$ruangan->nama_ruangan} tidak tersedia untuk peminjaman.");
                }
                

                $jadwals = Jadwal::where('id_ruangan', $ruanganId)
                                ->where('tanggal', $request->tanggal_booking)
                                ->where('jam_mulai', '<=', $startTime)
                                ->where('jam_selesai', '>=', $endTime)
                                ->where('status', 'tersedia')
                                ->get();
                
                if ($jadwals->isEmpty()) {
                    return redirect()->back()->with('error', "Jadwal yang dipilih tidak tersedia untuk ruangan {$ruangan->nama_ruangan}.");
                }
                
                $itemKey = $ruanganId . '_' . $request->tanggal_booking . '_' . $startTime . '_' . $endTime;
                $jadwalIds = $jadwals->pluck('id')->toArray();
                
                $itemData = [
                    'id' => $ruangan->id,
                    'nama_ruangan' => $ruangan->nama_ruangan,
                    'kapasitas' => $ruangan->kapasitas,
                    'lokasi' => $ruangan->lokasi,
                    'deskripsi' => $ruangan->deskripsi,
                    'foto' => $ruangan->foto,
                    'tanggal_booking' => $request->tanggal_booking,
                    'waktu_mulai' => $startTime,
                    'waktu_selesai' => $endTime,
                    'jadwal_ids' => $jadwalIds
                ];
                
                $cart[$itemKey] = $itemData;
            }
            
            Session::put('cart_ruangan', $cart);
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('success', 'Ruangan berhasil ditambahkan ke keranjang.');
        } else {

            return redirect()->route('mahasiswa.cart.keranjang_ruangan.schedule-form', [
                'ruangan_ids' => implode(',', $request->ruangan_ids)
            ]);
        }
    }
}