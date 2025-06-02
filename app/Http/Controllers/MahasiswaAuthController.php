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
use App\Models\PinjamInventaris;

class MahasiswaAuthController extends Controller
{
    protected function guard()
    {
    return Auth::guard('mahasiswa');
    }



    public function register(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:mahasiswa,nim',
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|email|unique:mahasiswa,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

   
        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama_mahasiswa' => $request->nama_mahasiswa,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

   
        Auth::guard('mahasiswa')->login($mahasiswa);
        
   
        $request->session()->regenerate();
        
   
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
        $mahasiswaId = Session::get('mahasiswa_id');

        if (!$mahasiswaId) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = Mahasiswa::find($mahasiswaId);

        if (!$mahasiswa) {
            Session::flush();
            return redirect()->route('mahasiswa.login')->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $ruangans = Ruangan::latest()->take(3)->get();

        $inventaris = Inventaris::latest()->take(3)->get();


        $peminjamanRuanganDiterima = PinjamRuangan::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 1)
            ->with('ruangan')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' .
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
            })
            ->map(function($group, $key) {
                $firstItem = $group->first();
                $roomNames = $group->pluck('ruangan.nama_ruangan')->filter()->implode(', ');
                return [
                    'key' => $key,
                    'id' => $firstItem->id,
                    'nama' => $roomNames ?: 'Ruangan tidak ditemukan',
                    'jenis' => 'Ruangan',
                    'tanggal' => $firstItem->tanggal_pengajuan,
                    'notes' => $firstItem->notes,
                    'count' => $group->count()
                ];
            });

        $peminjamanInventarisDiterima = PinjamInventaris::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 1)
            ->with('inventaris')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' .
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
            })
            ->map(function($group, $key) {
                $firstItem = $group->first();
                $inventoryNames = $group->pluck('inventaris.nama_inventaris')->filter()->implode(', ');
                return [
                    'key' => $key,
                    'id' => $firstItem->id,
                    'nama' => $inventoryNames ?: 'Inventaris tidak ditemukan',
                    'jenis' => 'Inventaris',
                    'tanggal' => $firstItem->tanggal_pengajuan,
                    'notes' => $firstItem->notes,
                    'count' => $group->count()
                ];
            });

        $peminjamanDiterima = collect($peminjamanRuanganDiterima->values())
            ->merge($peminjamanInventarisDiterima->values());


        $peminjamanRuanganDitolak = PinjamRuangan::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 2)
            ->with('ruangan')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' .
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
            })
            ->map(function($group, $key) {
                $firstItem = $group->first();
                $roomNames = $group->pluck('ruangan.nama_ruangan')->filter()->implode(', ');
                return [
                    'key' => $key,
                    'id' => $firstItem->id,
                    'nama' => $roomNames ?: 'Ruangan tidak ditemukan',
                    'jenis' => 'Ruangan',
                    'tanggal' => $firstItem->tanggal_pengajuan,
                    'notes' => $firstItem->notes,
                    'count' => $group->count()
                ];
            });

        $peminjamanInventarisDitolak = PinjamInventaris::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 2)
            ->with('inventaris')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' .
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
            })
            ->map(function($group, $key) {
                $firstItem = $group->first();
                $inventoryNames = $group->pluck('inventaris.nama_inventaris')->filter()->implode(', ');
                return [
                    'key' => $key,
                    'id' => $firstItem->id,
                    'nama' => $inventoryNames ?: 'Inventaris tidak ditemukan',
                    'jenis' => 'Inventaris',
                    'tanggal' => $firstItem->tanggal_pengajuan,
                    'notes' => $firstItem->notes,
                    'count' => $group->count()
                ];
            });

        $peminjamanDitolak = collect($peminjamanRuanganDitolak->values())
            ->merge($peminjamanInventarisDitolak->values());


        $peminjamanRuanganPending = PinjamRuangan::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 0)
            ->with('ruangan')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' .
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
            })
            ->map(function($group, $key) {
                $firstItem = $group->first();
                $roomNames = $group->pluck('ruangan.nama_ruangan')->filter()->implode(', ');
                return [
                    'key' => $key,
                    'id' => $firstItem->id,
                    'nama' => $roomNames ?: 'Ruangan tidak ditemukan',
                    'jenis' => 'Ruangan',
                    'tanggal' => $firstItem->tanggal_pengajuan,
                    'notes' => $firstItem->notes,
                    'count' => $group->count()
                ];
            });

        $peminjamanInventarisPending = PinjamInventaris::where('id_mahasiswa', $mahasiswaId)
            ->where('status', 0)
            ->with('inventaris')
            ->get()
            ->groupBy(function($item) {
                return $item->tanggal_pengajuan . '-' . $item->tanggal_selesai . '-' .
                    $item->waktu_mulai . '-' . $item->waktu_selesai . '-' . $item->file_scan;
            })
            ->map(function($group, $key) {
                $firstItem = $group->first();
                $inventoryNames = $group->pluck('inventaris.nama_inventaris')->filter()->implode(', ');
                return [
                    'key' => $key,
                    'id' => $firstItem->id,
                    'nama' => $inventoryNames ?: 'Inventaris tidak ditemukan',
                    'jenis' => 'Inventaris',
                    'tanggal' => $firstItem->tanggal_pengajuan,
                    'notes' => $firstItem->notes,
                    'count' => $group->count()
                ];
            });

        $peminjamanPending = collect($peminjamanRuanganPending->values())
            ->merge($peminjamanInventarisPending->values());

        return view('mahasiswa.page.dashboard', compact(
            'mahasiswa', 'ruangans', 'inventaris',
            'peminjamanDiterima', 'peminjamanDitolak', 'peminjamanPending'
        ));
    }
    public function landing()
    {
   
        $totalRuangan = \App\Models\Ruangan::count();
        $ruanganTersedia = \App\Models\Ruangan::where('status', 'Tersedia')->count();
        $totalInventaris = \App\Models\Inventaris::count();
        $inventarisTersedia = \App\Models\Inventaris::where('status', 'Tersedia')->count();
        
   
        $ruangans = \App\Models\Ruangan::latest()->take(6)->get();
        $inventaris = \App\Models\Inventaris::latest()->take(6)->get();

        return view('landing', compact(
            'ruangans',
            'inventaris',
            'totalRuangan',
            'ruanganTersedia',
            'totalInventaris',
            'inventarisTersedia'
        ));
    }

    public function edit(Request $request): View
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('profile.edit', compact('mahasiswa'));
    }



}
