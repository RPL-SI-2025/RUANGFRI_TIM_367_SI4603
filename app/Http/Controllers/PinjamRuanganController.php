<?php

namespace App\Http\Controllers;

use App\Models\PinjamRuangan;
use App\Models\Ruangan;
use App\Models\Mahasiswa;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PinjamRuanganController extends Controller
{


    public function mahasiswaIndex()
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        

        $pinjamRuangan = PinjamRuangan::with('ruangan')
                    ->where('id_mahasiswa', $mahasiswaId)
                    ->latest()
                    ->get();
                    

        $groupedPinjamRuangan = $pinjamRuangan->groupBy(function($item) {
            return $item->id;
        });
        

        $perPage = 10;
        $currentPage = request()->input('page', 1);
        $pagedData = $groupedPinjamRuangan->forPage($currentPage, $perPage);
        
        $paginatedPinjamRuangan = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedData,
            $groupedPinjamRuangan->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
                    
        return view('mahasiswa.peminjaman.pinjam_ruangan.index', compact('paginatedPinjamRuangan'));
    }
    

    public function create()
    {
        $cartItems = Session::get('cart_ruangan', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')->with('error', 'Keranjang ruangan Anda kosong!');
        }
        
        return view('mahasiswa.peminjaman.pinjam_ruangan.create', compact('cartItems'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tujuan_peminjaman' => 'required|string',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }
        
        $cartItems = Session::get('cart_ruangan', []);
        
        if(empty($cartItems)) {
            return redirect()->route('mahasiswa.cart.keranjang_ruangan.index')
                ->with('error', 'Keranjang ruangan Anda kosong!');
        }
        

        DB::beginTransaction();
        
        try {
            $fileName = null;
            if ($request->hasFile('file_scan')) {
                $file = $request->file('file_scan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/file_scan', $fileName, 'public');
            }
            

            foreach ($cartItems as $key => $item) {
                $pinjamRuangan = PinjamRuangan::create([
                    'id_ruangan' => $item['id'],
                    'id_mahasiswa' => $mahasiswaId,
                    'tanggal_pengajuan' => $request->tanggal_pengajuan,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'waktu_mulai' => $request->waktu_mulai,
                    'waktu_selesai' => $request->waktu_selesai,
                    'tujuan_peminjaman' => $request->tujuan_peminjaman,
                    'file_scan' => $fileName,
                    'status' => 0 
                ]);
                

                if (isset($item['selected_slots']) && !empty($item['selected_slots']) && is_array($item['selected_slots'])) {

                    foreach ($item['selected_slots'] as $slot) {
                        $slotStart = Carbon::parse($slot['start'])->format('H:i:s');
                        $slotEnd = Carbon::parse($slot['end'])->format('H:i:s');
                        

                        $jadwal = Jadwal::where('id_ruangan', $item['id'])
                            ->where('tanggal', $request->tanggal_pengajuan)
                            ->where('jam_mulai', $slotStart)
                            ->where('jam_selesai', $slotEnd)
                            ->first();
                            
                        if ($jadwal) {
                            $jadwal->status = 'proses';
                            $jadwal->id_pinjam_ruangan = $pinjamRuangan->id;
                            $jadwal->save();
                        }
                    }
                } else {

                    $startTime = Carbon::parse($request->waktu_mulai)->format('H:i:s');
                    $endTime = Carbon::parse($request->waktu_selesai)->format('H:i:s');
                    $startDate = Carbon::parse($request->tanggal_pengajuan);
                    $endDate = Carbon::parse($request->tanggal_selesai);
                    

                    $availableJadwals = Jadwal::where('id_ruangan', $item['id'])
                        ->whereBetween('tanggal', [$startDate, $endDate])
                        ->where('status', 'tersedia')
                        ->where(function($query) use ($startTime, $endTime) {
                            $query->where(function($q) use ($startTime, $endTime) {
                                $q->where('jam_mulai', '<=', $startTime)
                                    ->where('jam_selesai', '>', $startTime);
                            })->orWhere(function($q) use ($startTime, $endTime) {
                                $q->where('jam_mulai', '<', $endTime)
                                    ->where('jam_selesai', '>=', $endTime);
                            })->orWhere(function($q) use ($startTime, $endTime) {
                                $q->where('jam_mulai', '>=', $startTime)
                                    ->where('jam_selesai', '<=', $endTime);
                            });
                        })
                        ->get();
                    
                    if ($availableJadwals->isEmpty()) {
                        DB::rollBack();
                        return redirect()->back()->with('error', 'Jadwal yang dipilih untuk ruangan ini tidak tersedia.');
                    }
                    

                    foreach ($availableJadwals as $jadwal) {
                        $jadwal->status = 'proses';
                        $jadwal->id_pinjam_ruangan = $pinjamRuangan->id;
                        $jadwal->save();
                    }
                }
            }
            

            Session::forget('cart_ruangan');
            
            DB::commit();
            
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('success', 'Pengajuan peminjaman ruangan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses peminjaman: ' . $e->getMessage());
        }
    }


    public function show(PinjamRuangan $pinjamRuangan)
        {
            $mahasiswaId = Session::get('mahasiswa_id');
            
            if ($pinjamRuangan->id_mahasiswa != $mahasiswaId) {
                return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                    ->with('error', 'Anda tidak diizinkan melihat peminjaman ini.');
            }
            

            $relatedRooms = PinjamRuangan::where('id', $pinjamRuangan->id)
                ->with('ruangan')
                ->get();
            
            return view('mahasiswa.peminjaman.pinjam_ruangan.show', compact('pinjamRuangan', 'relatedRooms'));
        }


    public function edit(PinjamRuangan $pinjamRuangan)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId || $pinjamRuangan->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit peminjaman ini.');
        }
        

        if (in_array($pinjamRuangan->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diedit.');
        }
        

        $relatedBookings = PinjamRuangan::where('id', $pinjamRuangan->id)
            ->with('ruangan')
            ->get();
        
        return view('mahasiswa.peminjaman.pinjam_ruangan.edit', compact('pinjamRuangan', 'relatedBookings'));
    }


    public function update(Request $request, PinjamRuangan $pinjamRuangan)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        
        if (!$mahasiswaId || $pinjamRuangan->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah peminjaman ini.');
        }
    
        
        if (in_array($pinjamRuangan->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat diubah.');
        }
        if ($pinjamRuangan->tanggal_pengajuan == $pinjamRuangan->tanggal_selesai) {
            $request->merge([
                'tanggal_selesai' => $request->input('tanggal_pengajuan')
            ]);
        }

        $request->validate([
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required|after:waktu_mulai',
            'tujuan_peminjaman' => 'required|string',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        
        DB::beginTransaction();
        
        try {

            $fileName = $pinjamRuangan->file_scan;
            if ($request->hasFile('file_scan')) {

                if ($pinjamRuangan->file_scan) {
                    Storage::disk('public')->delete('uploads/file_scan/' . $pinjamRuangan->file_scan);
                }
                
                $file = $request->file('file_scan');
                $fileName = time() . '_' . $file->getClientOriginalName();
                Storage::disk('public')->putFileAs('uploads/file_scan', $file, $fileName);
            }


            $oldStartTime = $pinjamRuangan->waktu_mulai;
            $oldEndTime = $pinjamRuangan->waktu_selesai;
            $oldStartDate = $pinjamRuangan->tanggal_pengajuan;
            $oldEndDate = $pinjamRuangan->tanggal_selesai;
            $sameDay = $oldStartDate == $oldEndDate;
            

            $relatedBookings = PinjamRuangan::where('tanggal_pengajuan', $oldStartDate)
                ->where('tanggal_selesai', $oldEndDate)
                ->where('waktu_mulai', $oldStartTime)
                ->where('waktu_selesai', $oldEndTime)
                ->where('file_scan', $pinjamRuangan->file_scan)
                ->where('id_mahasiswa', $mahasiswaId)
                ->get();
                

            foreach ($relatedBookings as $booking) {

                Jadwal::where('id_pinjam_ruangan', $booking->id)
                    ->update([
                        'status' => 'tersedia',
                        'id_pinjam_ruangan' => null
                    ]);
            }
            


            $newEndDate = $sameDay ? $request->tanggal_pengajuan : $request->tanggal_selesai;
            

            foreach ($relatedBookings as $booking) {
                $booking->tanggal_pengajuan = $request->tanggal_pengajuan;
                $booking->tanggal_selesai = $newEndDate;
                $booking->waktu_mulai = $request->waktu_mulai;
                $booking->waktu_selesai = $request->waktu_selesai;
                $booking->tujuan_peminjaman = $request->tujuan_peminjaman;
                
                if ($request->hasFile('file_scan')) {
                    $booking->file_scan = $fileName;
                }
                
                $booking->save();
            }


            if ($request->has('selected_slots_json') && !empty($request->selected_slots_json)) {
                $selectedSlots = json_decode($request->selected_slots_json, true);
                
                if (!empty($selectedSlots) && is_array($selectedSlots)) {

                    foreach ($relatedBookings as $booking) {
                        $ruanganId = $booking->id_ruangan;
                        
                        foreach ($selectedSlots as $slot) {
                            $slotStart = Carbon::parse($slot['start'])->format('H:i:s');
                            $slotEnd = Carbon::parse($slot['end'])->format('H:i:s');
                            

                            $jadwal = Jadwal::where('id_ruangan', $ruanganId)
                                ->where('tanggal', $request->tanggal_pengajuan)
                                ->where('jam_mulai', $slotStart)
                                ->where('jam_selesai', $slotEnd)
                                ->first();
                                
                            if ($jadwal) {
                                $jadwal->status = 'proses';
                                $jadwal->id_pinjam_ruangan = $booking->id;
                                $jadwal->save();
                            }
                        }
                    }
                }
            } else {

                $startTime = Carbon::parse($request->waktu_mulai)->format('H:i:s');
                $endTime = Carbon::parse($request->waktu_selesai)->format('H:i:s');
                $startDate = Carbon::parse($request->tanggal_pengajuan);
                $endDate = Carbon::parse($newEndDate);
                
                foreach ($relatedBookings as $booking) {
                    $ruanganId = $booking->id_ruangan;
                    

                    $availableJadwals = Jadwal::where('id_ruangan', $ruanganId)
                        ->whereBetween('tanggal', [$startDate, $endDate])
                        ->where('status', 'tersedia')
                        ->where(function($query) use ($startTime, $endTime) {
                            $query->where(function($q) use ($startTime, $endTime) {
                                $q->where('jam_mulai', '<=', $startTime)
                                    ->where('jam_selesai', '>', $startTime);
                            })->orWhere(function($q) use ($startTime, $endTime) {
                                $q->where('jam_mulai', '<', $endTime)
                                    ->where('jam_selesai', '>=', $endTime);
                            })->orWhere(function($q) use ($startTime, $endTime) {
                                $q->where('jam_mulai', '>=', $startTime)
                                    ->where('jam_selesai', '<=', $endTime);
                            });
                        })
                        ->get();
                    
                    if ($availableJadwals->isEmpty()) {
                        DB::rollBack();
                        return redirect()->back()
                            ->with('error', 'Jadwal yang dipilih untuk ruangan ini tidak tersedia. Silakan pilih tanggal atau waktu lain.');
                    }
                    

                    foreach ($availableJadwals as $jadwal) {
                        $jadwal->status = 'proses';
                        $jadwal->id_pinjam_ruangan = $booking->id;
                        $jadwal->save();
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('success', 'Pengajuan peminjaman ruangan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    


    public function updateStatus(Request $request, PinjamRuangan $pinjamRuangan)
    {
        $request->validate([
            'status' => 'required|integer|min:0|max:4',
            'catatan' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        
        try {
            $pinjamRuangan->status = $request->status;
            $pinjamRuangan->catatan = $request->catatan;
            $pinjamRuangan->save();
            

            PinjamRuangan::where('id', $pinjamRuangan->id)
                ->update(['status' => $request->status]);


            if ($request->status == 1) { 

                $this->updateJadwalStatus($pinjamRuangan, 'booked');
                

                $affectedRoomIds = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                    ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                    ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                    ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                    ->where('file_scan', $pinjamRuangan->file_scan)
                    ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
                    ->pluck('id_ruangan');
                

                foreach ($affectedRoomIds as $roomId) {

                    $totalJadwals = Jadwal::where('id_ruangan', $roomId)->count();
                    

                    $bookedJadwals = Jadwal::where('id_ruangan', $roomId)
                        ->whereIn('status', ['booked', 'proses'])
                        ->count();
                    

                    if ($totalJadwals > 0 && $totalJadwals == $bookedJadwals) {
                        Ruangan::where('id', $roomId)->update(['status' => 'Tidak Tersedia']);
                    } else {

                        Ruangan::where('id', $roomId)->update(['status' => 'Tersedia']);
                    }
                }
            } elseif ($request->status == 2 || $request->status == 4) { 
                $this->updateJadwalStatus($pinjamRuangan, 'tersedia');
                

                $affectedRoomIds = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                    ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                    ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                    ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                    ->where('file_scan', $pinjamRuangan->file_scan)
                    ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
                    ->pluck('id_ruangan');
                    
                Ruangan::whereIn('id', $affectedRoomIds)
                    ->update(['status' => 'Tersedia']);
                    
            } elseif ($request->status == 3) { 
                $this->updateJadwalStatus($pinjamRuangan, 'tersedia');
                

                $affectedRoomIds = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                    ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                    ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                    ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                    ->where('file_scan', $pinjamRuangan->file_scan)
                    ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
                    ->pluck('id_ruangan');
                    
                Ruangan::whereIn('id', $affectedRoomIds)
                    ->update(['status' => 'Tersedia']);
            }
            
            DB::commit();
            
            $statusText = match($request->status) {
                0 => 'menunggu persetujuan',
                1 => 'disetujui',
                2 => 'ditolak',
                3 => 'selesai',
                4 => 'dibatalkan',
                default => 'diperbarui'
            };
            
            return back()->with('success', "Status peminjaman ruangan berhasil $statusText.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function updateNotes(Request $request, PinjamRuangan $pinjamRuangan)
    {
        $request->validate([
            'catatan' => 'nullable|string|max:500',
        ]);
        
        $pinjamRuangan->catatan = $request->catatan;
        $pinjamRuangan->save();
        
        return back()->with('success', 'Catatan berhasil diperbarui.');
    }


    public function adminIndex()
    {
       $peminjaman = PinjamRuangan::with(['ruangan','mahasiswa'])->latest()->get();

       $groupedPeminjaman = $peminjaman->groupBy(function($item) {
            return $item->id;
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

        return view('admin.pinjam_ruangan.index', compact('paginatedGroupedPeminjaman'));
    }
    

    public function adminShow(PinjamRuangan $pinjamRuangan)
    {
        $relatedItems = PinjamRuangan::where('id', $pinjamRuangan->id)
            ->with(['ruangan', 'mahasiswa'])
            ->get();
            
        return view('admin.pinjam_ruangan.show', compact('pinjamRuangan', 'relatedItems'));
    }


    public function cancel(PinjamRuangan $pinjamRuangan)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        

        if (!$mahasiswaId || $pinjamRuangan->id_mahasiswa != $mahasiswaId) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Anda tidak memiliki akses untuk membatalkan peminjaman ini.');
        }
        
        
        if (in_array($pinjamRuangan->status, [1, 3])) {
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Peminjaman yang sudah disetujui atau selesai tidak dapat dibatalkan.');
        }
        
        DB::beginTransaction();
        
        try {

            $pinjamRuangan->status = 4;
            $pinjamRuangan->save();
            

            PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                ->where('file_scan', $pinjamRuangan->file_scan)
                ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
                ->update(['status' => 4]);


            $this->updateJadwalStatus($pinjamRuangan, 'tersedia');


            $affectedRoomIds = PinjamRuangan::where('tanggal_pengajuan', $pinjamRuangan->tanggal_pengajuan)
                ->where('tanggal_selesai', $pinjamRuangan->tanggal_selesai)
                ->where('waktu_mulai', $pinjamRuangan->waktu_mulai)
                ->where('waktu_selesai', $pinjamRuangan->waktu_selesai)
                ->where('file_scan', $pinjamRuangan->file_scan)
                ->where('id_mahasiswa', $pinjamRuangan->id_mahasiswa)
                ->pluck('id_ruangan');
            
            foreach ($affectedRoomIds as $roomId) {

                $bookedJadwals = Jadwal::where('id_ruangan', $roomId)
                    ->whereIn('status', ['booked', 'proses'])
                    ->count();


                if ($bookedJadwals == 0) {
                    Ruangan::where('id', $roomId)->update(['status' => 'Tersedia']);
                }
            }
            
            DB::commit();
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('success', 'Peminjaman ruangan berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mahasiswa.peminjaman.pinjam-ruangan.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

  
    public function updateJadwalStatus($pinjamRuangan, $status)
    {

        $affectedJadwals = Jadwal::where('id_ruangan', $pinjamRuangan->id_ruangan)
            ->where(function($query) use ($pinjamRuangan) {

                $query->where('id_pinjam_ruangan', $pinjamRuangan->id)
                    ->orWhere(function($q) use ($pinjamRuangan) {
                        $q->whereBetween('tanggal', [$pinjamRuangan->tanggal_pengajuan, $pinjamRuangan->tanggal_selesai])
                            ->where(function($innerQ) use ($pinjamRuangan) {

                                $startTime = Carbon::parse($pinjamRuangan->waktu_mulai)->format('H:i:s');
                                $endTime = Carbon::parse($pinjamRuangan->waktu_selesai)->format('H:i:s');
                                
                                $innerQ->where(function($timeQ) use ($startTime, $endTime) {
                                    $timeQ->where('jam_mulai', '<=', $startTime)
                                        ->where('jam_selesai', '>', $startTime);
                                })->orWhere(function($timeQ) use ($startTime, $endTime) {
                                    $timeQ->where('jam_mulai', '<', $endTime)
                                        ->where('jam_selesai', '>=', $endTime);
                                })->orWhere(function($timeQ) use ($startTime, $endTime) {
                                    $timeQ->where('jam_mulai', '>=', $startTime)
                                        ->where('jam_selesai', '<=', $endTime);
                                });
                            });
                    });
            })
            ->get();
            
        foreach ($affectedJadwals as $jadwal) {

            $jadwal->status = $status;
            

            if ($status === 'tersedia') {
                $jadwal->id_pinjam_ruangan = null;
            } else {
                $jadwal->id_pinjam_ruangan = $pinjamRuangan->id;
            }
            
            $jadwal->save();
        }
        


        if ($status === 'tersedia') {
            $pendingBookings = PinjamRuangan::where('id_ruangan', $pinjamRuangan->id_ruangan)
                ->where('status', 0) 
                ->where('id', '!=', $pinjamRuangan->id) 
                ->where(function($q) use ($pinjamRuangan) {

                    $q->whereBetween('tanggal_pengajuan', [$pinjamRuangan->tanggal_pengajuan, $pinjamRuangan->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$pinjamRuangan->tanggal_pengajuan, $pinjamRuangan->tanggal_selesai]);
                })
                ->get();
            
            foreach ($pendingBookings as $booking) {
                $bookingStartTime = Carbon::parse($booking->waktu_mulai);
                $bookingEndTime = Carbon::parse($booking->waktu_selesai);
                

                $jadwals = Jadwal::where('id_ruangan', $booking->id_ruangan)
                    ->where('tanggal', '>=', $booking->tanggal_pengajuan)
                    ->where('tanggal', '<=', $booking->tanggal_selesai)
                    ->where('status', 'tersedia')
                    ->get();
                
                foreach ($jadwals as $jadwal) {
                    $jadwalStartTime = Carbon::parse($jadwal->jam_mulai);
                    $jadwalEndTime = Carbon::parse($jadwal->jam_selesai);
                    

                    if (
                        ($bookingStartTime <= $jadwalStartTime && $bookingEndTime > $jadwalStartTime) ||
                        ($bookingStartTime < $jadwalEndTime && $bookingEndTime >= $jadwalEndTime) ||
                        ($bookingStartTime >= $jadwalStartTime && $bookingEndTime <= $jadwalEndTime)
                    ) {

                        $jadwal->status = 'proses';
                        $jadwal->id_pinjam_ruangan = $booking->id;
                        $jadwal->save();
                    }
                }
            }
        }
    }

}