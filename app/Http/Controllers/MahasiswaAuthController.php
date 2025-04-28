<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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

    public function edit()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswa,email,' . Auth::guard('mahasiswa')->id(),
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();
        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->email = $request->email;
        $mahasiswa->save();

        return redirect()->route('mahasiswa.profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak valid.']);
        }

        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->save();

        return redirect()->route('mahasiswa.profile.edit')->with('status', 'Password berhasil diperbarui!');
    }

    public function destroy()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        $mahasiswa->delete();

        Auth::guard('mahasiswa')->logout();

        return redirect()->route('mahasiswa.login')->with('status', 'Akun berhasil dihapus.');
    }
}
