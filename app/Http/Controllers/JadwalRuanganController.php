<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JadwalRuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = Jadwal::orderBy('tanggal')->get();
        $groupedJadwals = $jadwals->groupBy('id_ruangan');
        return view('admin.jadwal.index', compact('jadwals'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ruangans = Ruangan::where('status', 'Tersedia')->get();
        return view('admin.jadwal.create', compact('ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'jeda_waktu' => 'required|integer|min:1|max:4'
        ]);

        try {

            $startTime = Carbon::parse($request->jam_mulai);
            $endTime = Carbon::parse($request->jam_selesai);
            $interval = $request->jeda_waktu * 60; // Convert to minutes
            
            DB::beginTransaction();
            
            while ($startTime->copy()->addMinutes($interval) <= $endTime) {
                $slotEndTime = $startTime->copy()->addMinutes($interval);
                
                Jadwal::create([
                    'id_ruangan' => $request->id_ruangan,
                    'tanggal' => $request->tanggal,
                    'jam_mulai' => $startTime->format('H:i:s'),
                    'jam_selesai' => $slotEndTime->format('H:i:s'),
                    'status' => 'tersedia',
                ]);
                
                $startTime->addMinutes($interval);
            }
            
            DB::commit();
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */

    public function show($ruanganId)
    {
        $ruangan = Ruangan::findOrFail($ruanganId);
        

        $allJadwals = Jadwal::where('id_ruangan', $ruanganId)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();
        

        $jadwalsQuery = Jadwal::where('id_ruangan', $ruanganId);
        

        if (request()->has('status') && request('status') != '') {
            $jadwalsQuery->where('status', request('status'));
        }
        

        if (request()->has('start_date') && request('start_date') != '') {
            $jadwalsQuery->where('tanggal', '>=', request('start_date'));
        }
        
        if (request()->has('end_date') && request('end_date') != '') {
            $jadwalsQuery->where('tanggal', '<=', request('end_date'));
        }
        

        $jadwals = $jadwalsQuery->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get();
        
        return view('admin.jadwal.show', compact('ruangan', 'jadwals', 'allJadwals'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        $ruangans = Ruangan::where('status', 'Tersedia')->get();
        return view('admin.jadwal.edit', compact('jadwal', 'ruangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|in:tersedia,proses,booked'
        ]);


        if ($jadwal->status == 'booked' && $jadwal->id_pinjam_ruangan && $request->status != 'booked') {
            return redirect()->back()->with('error', 'Jadwal ini sudah dipesan dan tidak dapat diubah.');
        }

        $jadwal->update([
            'id_ruangan' => $request->id_ruangan,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {

        if ($jadwal->status == 'booked' && $jadwal->id_pinjam_ruangan) {
            return redirect()->back()->with('error', 'Jadwal ini sudah dipesan dan tidak dapat dihapus.');
        }

        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    /**
     * Generate jadwal for a specific ruangan
     */
    public function generateJadwal(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'jeda_waktu' => 'required|integer|min:1|max:4',
            'hari_operasional' => 'required|array',
            'hari_operasional.*' => 'required|integer|between:0,6', // 0 = Sunday, 6 = Saturday
        ]);

        try {
            $startDate = Carbon::parse($request->tanggal_mulai);
            $endDate = Carbon::parse($request->tanggal_selesai);
            $operationalDays = $request->hari_operasional;
            
            $startTime = Carbon::parse($request->jam_mulai);
            $endTime = Carbon::parse($request->jam_selesai);
            $interval = $request->jeda_waktu * 60; // Convert to minutes
            
            DB::beginTransaction();
            

            for ($date = $startDate; $date->lte($endDate); $date->addDay()) {

                if (in_array($date->dayOfWeek, $operationalDays)) {
                    $currentStartTime = $startTime->copy();
                    

                    while ($currentStartTime->copy()->addMinutes($interval) <= $endTime) {
                        $slotEndTime = $currentStartTime->copy()->addMinutes($interval);
                        
                        Jadwal::create([
                            'id_ruangan' => $request->id_ruangan,
                            'tanggal' => $date->format('Y-m-d'),
                            'jam_mulai' => $currentStartTime->format('H:i:s'),
                            'jam_selesai' => $slotEndTime->format('H:i:s'),
                            'status' => 'tersedia',
                        ]);
                        
                        $currentStartTime->addMinutes($interval);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Get jadwal data for a specific ruangan for calendar display
     */

    public function getRuanganJadwal($id_ruangan)
    {
        try {

            $jadwals = Jadwal::where('id_ruangan', $id_ruangan)
                    ->where('tanggal', '>=', now()->startOfMonth()->format('Y-m-d'))
                    ->where('tanggal', '<=', now()->addMonths(3)->endOfMonth()->format('Y-m-d'))
                    ->get();
            

            $jadwalsByDate = $jadwals->groupBy('tanggal');
            $formattedJadwal = [];
            
            foreach ($jadwalsByDate as $date => $dayJadwals) {

                $statusCounts = [
                    'tersedia' => $dayJadwals->where('status', 'tersedia')->count(),
                    'proses' => $dayJadwals->where('status', 'proses')->count(),
                    'booked' => $dayJadwals->where('status', 'booked')->count()
                ];
                

                $mainStatus = 'unavailable'; // Default
                if ($statusCounts['tersedia'] > 0) {
                    if ($statusCounts['booked'] > 0 || $statusCounts['proses'] > 0) {
                        $mainStatus = 'partially-available';
                    } else {
                        $mainStatus = 'tersedia';
                    }
                } else if ($statusCounts['proses'] > 0) {
                    $mainStatus = 'proses';
                } else if ($statusCounts['booked'] > 0) {
                    $mainStatus = 'booked';
                }
                

                $formattedJadwal[] = [
                    'date' => $date,
                    'status' => $mainStatus,
                    'available_count' => $statusCounts['tersedia'],
                    'pending_count' => $statusCounts['proses'],
                    'booked_count' => $statusCounts['booked'],
                    'total_slots' => $dayJadwals->count(),
                    'detail' => $dayJadwals->map(function($j) {
                        return [
                            'id' => $j->id,
                            'start_time' => $j->jam_mulai,
                            'end_time' => $j->jam_selesai,
                            'status' => $j->status
                        ];
                    })
                ];
            }
            
            return response()->json($formattedJadwal);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load jadwal data: ' . $e->getMessage()], 500);
        }
    }
    
    public function debugOperationalDays($id_ruangan)
    {
        $jadwals = Jadwal::where('id_ruangan', $id_ruangan)
                ->orderBy('tanggal')
                ->take(10)
                ->get();
                
        $debug = [];
        foreach ($jadwals as $jadwal) {
            $date = \Carbon\Carbon::parse($jadwal->tanggal);
            $debug[] = [
                'date' => $jadwal->tanggal,
                'day_name' => $date->format('l'),
                'carbon_day_of_week' => $date->dayOfWeek,
                'status' => $jadwal->status
            ];
        }
        
        return response()->json($debug);
    }
    /**
     * Get time slots for a specific ruangan and date
     */

    public function getTimeSlots(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal' => 'required|date'
        ]);
        
        try {

            $jadwals = Jadwal::where('id_ruangan', $request->id_ruangan)
                ->where('tanggal', $request->tanggal)
                ->orderBy('jam_mulai')
                ->get();
            
            $timeSlots = [];
            foreach ($jadwals as $jadwal) {
                $timeSlots[] = [
                    'id' => $jadwal->id,
                    'start' => date('H:i', strtotime($jadwal->jam_mulai)),
                    'end' => date('H:i', strtotime($jadwal->jam_selesai)),
                    'status' => $jadwal->status // Include the status in the response
                ];
            }
            
            return response()->json($timeSlots);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to load time slots: ' . $e->getMessage()], 500);
        }
    }
}