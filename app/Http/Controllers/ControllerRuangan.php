<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class ControllerRuangan extends Controller
{
    //
    public function index()
    {
        // Logic to display the list of rooms
        return view('ruangan.RuanganIndex');
    }
    public function create()
    {
        // Logic to show the form for creating a new room
        return view('ruangan.RuanganCreate');
    }
    public function store(Request $request)
    {
        // Logic to store a new room
        // Validate and save the room data
        $request->validate([
            'id_logistik' => 'required|unique:ruangan',
            'nama_ruangan' => 'required|unique:ruangan',
            'kapasitas' => 'required|integer',
            'fasilitas' => 'required|string',
            'lokasi' => 'required|string',
            'status' => 'required|string'
        ]);
        Ruangan::create(  $request->all());
        return redirect()->route('ruangan.index');
    }

}
