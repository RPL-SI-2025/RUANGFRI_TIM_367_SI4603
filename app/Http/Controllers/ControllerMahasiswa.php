<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class ControllerMahasiswa extends Controller
{
    //
    public function index()
    {
        // Logic to display the list of students
        return view('mahasiswa.MahasiswaIndex');
    }
    public function create()
    {
        // Logic to show the form for creating a new student
        return view('mahasiswa.MahasiswaCreate');
    }
    public function store(Request $request)
    {
        // Logic to store a new student
        // Validate and save the student data
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
