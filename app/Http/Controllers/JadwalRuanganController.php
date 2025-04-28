<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalRuanganController extends Controller
{
    //
    public function index()
    {
        // Logic to display the list of room schedules
        return view('ruangan.jadwal_ruangan.index');
    }

    public function create()
    {
        // Logic to show the form for creating a new room schedule
        return view('ruangan.jadwal_ruangan.create');
    }

    public function store(Request $request)
    {
        // Logic to store the room schedule details
        $validatedData = $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:0,1,2,3', // 0: Menunggu Persetujuan, 1: Disetujui, 2: Ditolak, 3: Selesai
        ]);

        // Store the room schedule in the database
        // JadwalRuangan::create($validatedData);

        return redirect()->route('jadwal_ruangan.index')->with('success', 'Room schedule created successfully!');
    }

        public function show($id)
    {        // Logic to display the details of a specific room schedule
        // $schedule = JadwalRuangan::findOrFail($id);
        return view('ruangan.jadwal_ruangan.show', compact('schedule'));
    }

    public function edit($id)
    {
        // Logic to show the form for editing a room schedule
        // $schedule = JadwalRuangan::findOrFail($id);
        return view('ruangan.jadwal_ruangan.edit', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update the room schedule details
        $validatedData = $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_pengajuan',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'status' => 'required|in:0,1,2,3', // 0: Menunggu Persetujuan, 1: Disetujui, 2: Ditolak, 3: Selesai
        ]);

        // Update the room schedule in the database
        // $schedule = JadwalRuangan::findOrFail($id);
        // $schedule->update($validatedData);

        return redirect()->route('jadwal_ruangan.index')->with('success', 'Room schedule updated successfully!');
    }

    public function destroy($id)
    {
        // Logic to delete a room schedule
        // $schedule = JadwalRuangan::findOrFail($id);
        // $schedule->delete();

        return redirect()->route('jadwal_ruangan.index')->with('success', 'Room schedule deleted successfully!');
    }

}
