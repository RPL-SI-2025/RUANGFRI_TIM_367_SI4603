<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PinjamRuangan;
use Illuminate\Http\Request;

class PinjamRuanganController extends Controller
{
    //
    // Function to show the form for creating a new resource
    public function create()
    {
        return view('pinjamruangan.create');
    }
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'id_mahasiswa' => 'required|exists:mahasiswa,id',
            'id_jadwal' => 'required|exists:jadwal_ruangan,id',
            'id_logistik' => 'required|exists:admin_logistik,id',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'note' => 'nullable|string|max:255',
        ]);

        // Create a new PinjamRuangan instance and fill it with the request data
        $pinjamRuangan = new PinjamRuangan($request->all());

        // Save the instance to the database
        $pinjamRuangan->save();

        // Redirect to a specific route or return a response
        return redirect()->route('pinjamruangan.index')->with('success', 'Pinjam Ruangan created successfully!');
    }    public function show($id)
    {
        // Show the details of a specific PinjamRuangan
        $pinjamRuangan = PinjamRuangan::findOrFail($id);
        return view('pinjamruangan.show', compact('pinjamRuangan'));
    }
    public function edit($id)
    {
        // Show the form for editing a specific PinjamRuangan
        $pinjamRuangan = PinjamRuangan::findOrFail($id);
        return view('pinjamruangan.edit', compact('pinjamRuangan'));
    }
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id',
            'id_mahasiswa' => 'required|exists:mahasiswa,id',
            'id_jadwal' => 'required|exists:jadwal_ruangan,id',
            'id_logistik' => 'required|exists:admin_logistik,id',
            'tanggal_pengajuan' => 'required|date',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'required|date_format:H:i',
            'file_scan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'note' => 'nullable|string|max:255',
        ]);

        // Find the PinjamRuangan instance and update it with the request data
        $pinjamRuangan = PinjamRuangan::findOrFail($id);
        $pinjamRuangan->update($request->all());

        // Redirect to a specific route or return a response
        return redirect()->route('pinjamruangan.index')->with('success', 'Pinjam Ruangan updated successfully!');
    }
    public function destroy($id)
    {
        // Delete a specific PinjamRuangan
        $pinjamRuangan = PinjamRuangan::findOrFail($id);
        $pinjamRuangan->delete();

        // Redirect to a specific route or return a response
        return redirect()->route('pinjamruangan.index')->with('success', 'Pinjam Ruangan deleted successfully!');
    }
    public function index()
    {
        // Get all PinjamRuangan records
        $pinjamRuangan = PinjamRuangan::all();
        return view('pinjamruangan.index', compact('pinjamRuangan'));
    }
}
