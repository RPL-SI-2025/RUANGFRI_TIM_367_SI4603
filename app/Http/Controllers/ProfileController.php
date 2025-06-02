<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = Auth::guard('mahasiswa')->user();
        // Ambil tab aktif dari session, default ke 'profile'
        $activeTab = $request->session()->get('active_tab', 'profile');

        return view('profile.edit', compact('user', 'activeTab'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $this->validateProfile($request, $mahasiswa);

        $this->handleKTMUpload($request, $mahasiswa, $validated);

        $mahasiswa->update($validated);

        return Redirect::route('mahasiswa.profile.edit')
            ->with('status', 'Profil berhasil diperbarui!')
            ->with('active_tab', 'profile');
    }

    public function updateBorrowingInfo(Request $request): RedirectResponse
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $this->validateBorrowingInfo($request);

        $this->handleKTMUpload($request, $mahasiswa, $validated);

        $mahasiswa->update($validated);

        return redirect()->route('mahasiswa.profile.edit')
            ->with('status', 'Informasi peminjaman berhasil diperbarui!')
            ->with('active_tab', 'peminjaman');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', 'min:8'],
        ], [], [], 'updatePassword');

        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!Hash::check($request->current_password, $mahasiswa->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak valid.'], 'updatePassword');
        }

        $mahasiswa->password = Hash::make($request->password);
        $mahasiswa->save();

        return redirect()->route('mahasiswa.profile.edit')
            ->with('success', 'Password berhasil diperbarui!')
            ->with('active_tab', 'password');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = Auth::guard('mahasiswa')->user();

        $request->validate([
            'password' => ['required']
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password yang Anda masukkan salah.']);
        }

        Auth::guard('mahasiswa')->logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah berhasil dihapus.');
    }

    public function showProfile(): View
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('profile.show', compact('mahasiswa'));
    }

    private function validateProfile(Request $request, $mahasiswa): array
    {
        $minBirthDate = now()->subYears(17)->format('Y-m-d');

        return $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,

            'tempat_lahir' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[a-zA-Z\s\.\,\'\-]+$/'
            ],

            'tanggal_lahir' => [
                'nullable',
                'date',
                'before_or_equal:' . $minBirthDate,
                'before_or_equal:today',
            ],

            'wa' => [
                'nullable',
                'regex:/^\d+$/',
                'max:20'
            ],

            'alamat' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\.\,\'\-]+$/'
            ],

            'angkatan' => 'nullable|string|max:10',
            'tujuan' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',

            //Error handling
            'tempat_lahir.regex' => 'Tempat lahir hanya boleh berisi huruf, spasi, titik, koma, dan tanda hubung.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir harus membuat Anda minimal berusia 17 tahun dan tidak boleh tanggal di masa depan.',
            'wa.regex' => 'No. WhatsApp hanya boleh berisi angka tanpa spasi atau simbol.',
            'alamat.regex' => 'Alamat hanya boleh berisi huruf, spasi, titik, koma, dan tanda hubung tanpa angka atau simbol aneh.',
        ]);
    }

    private function validateBorrowingInfo(Request $request): array
    {
        return $request->validate([
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|string|max:10',
            'instansi' => 'required|string|max:255',
            'tujuan' => 'required|string|max:255',
            'ktm' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
    }

    private function handleKTMUpload(Request $request, $user, array &$validated): void
    {

        if ($request->hasFile('ktm')) {
            $ktmPath = $request->file('ktm')->store('ktm', 'public');
            $user->ktm = $ktmPath;
            $user->save();
        }
    }

}
