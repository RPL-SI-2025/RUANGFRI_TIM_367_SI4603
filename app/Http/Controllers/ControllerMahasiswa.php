<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class ControllerMahasiswa extends Controller
{

    public function index()
    {

        return view('mahasiswa.MahasiswaIndex');
    }
    public function create()
    {

        return view('mahasiswa.MahasiswaCreate');
    }
    public function store(Request $request)
    {


        $request->validate([
            'nim' => 'required|unique:mahasiswa',
            'nama_mahasiswa' => 'required|string',
            'email' => 'required|email|unique:mahasiswa',
            'password' => 'required|string|min:6'
        ]);
        Mahasiswa::create($request->all());
        return redirect()->route('mahasiswa.index');
    }
}

