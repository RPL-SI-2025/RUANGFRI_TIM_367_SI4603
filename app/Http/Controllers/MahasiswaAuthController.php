<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Ruangan;
use App\Models\Inventaris;
use App\Models\Peminjaman;
use App\Models\PinjamRuangan;

class MahasiswaAuthController extends Controller
{
    protected function guard()
    {
    return Auth::guard('mahasiswa');
    }

    public function showRegistrationForm()
{
    return view('mahasiswa.auth.register');
}

    public function register(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|unique:mahasiswa,nim',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswa,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('mahasiswa')->login($mahasiswa);
        
        Session::put('mahasiswa_id', $mahasiswa->id);
        Session::put('mahasiswa_name', $mahasiswa->nama_mahasiswa);
        Session::put('mahasiswa_nim', $mahasiswa->nim);
        Session::put('mahasiswa_email', $mahasiswa->email);
        Session::put('is_logged_in', true);
        
        return redirect()->route('mahasiswa.dashboard')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di Sistem Peminjaman Inventaris.');
    }
    public function showLoginForm()
    {
        return view('mahasiswa.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $mahasiswa = Auth::guard('mahasiswa')->user();
            Session::put('mahasiswa_id', $mahasiswa->id);
            Session::put('mahasiswa_name', $mahasiswa->nama_mahasiswa);
            Session::put('mahasiswa_nim', $mahasiswa->nim);
            Session::put('mahasiswa_email', $mahasiswa->email);
            Session::put('is_logged_in', true);
            
            return redirect()->intended('/mahasiswa/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Session::forget(['mahasiswa_id', 'mahasiswa_name', 'mahasiswa_email', 'mahasiswa_nim', 'is_logged_in']);
        Session::flush();
        
        return redirect()->route('mahasiswa.login');
    }



    public function dashboard()
    {
        // Ambil 3 ruangan untuk katalog ringkas
        $ruangans = \App\Models\Ruangan::take(3)->get();

        // Debugging
        if ($ruangans->isEmpty()) {
            dd('Tidak ada data ruangan');
        }

        // Ambil 3 inventaris untuk katalog ringkas
        $inventaris = \App\Models\Inventaris::take(3)->get();

        // Ambil data peminjaman berdasarkan status
        $peminjamanDiterima = \App\Models\PinjamRuangan::where('status', 'Diterima')->get();
        $peminjamanDitolak = \App\Models\PinjamRuangan::where('status', 'Ditolak')->get();
        $peminjamanPending = \App\Models\PinjamRuangan::where('status', 'Pending')->get();

        // Kirim data ke view
        return view('mahasiswa.page.dashboard', compact('ruangans', 'inventaris', 'peminjamanDiterima', 'peminjamanDitolak', 'peminjamanPending'));
    }

}