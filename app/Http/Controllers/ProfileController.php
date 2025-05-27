<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('profile.edit', compact('mahasiswa'));
    }

    public function update(Request $request): RedirectResponse
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $validated = $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswa->id,
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'no_telepon' => 'nullable|string|max:20',
            'wa' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string|max:10',
            'tujuan' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|max:2048',
            'ktm' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($mahasiswa->profile_photo) {
                Storage::disk('public')->delete($mahasiswa->profile_photo);
            }
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        if ($request->has('delete_photo')) {
            if ($mahasiswa->profile_photo) {
                Storage::disk('public')->delete($mahasiswa->profile_photo);
                $validated['profile_photo'] = null;
            }
        }

        if ($request->hasFile('ktm')) {
            if ($mahasiswa->ktm) {
                Storage::disk('public')->delete($mahasiswa->ktm);
            }
            $validated['ktm'] = $request->file('ktm')->store('ktm_files', 'public');
        } elseif (!$mahasiswa->ktm) {
            return back()->withErrors(['ktm' => 'KTM wajib diunggah.']);
        }

        $mahasiswa->update($validated);

        return Redirect::route('mahasiswa.profile.edit')->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

     public function updateProfile(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswa,email,' . $mahasiswa->id,
        ]);

        $mahasiswa->nama_mahasiswa = $request->nama_mahasiswa;
        $mahasiswa->email = $request->email;
        $mahasiswa->save();

        return redirect()->route('profile.edit')->with('status', 'Profil berhasil diperbarui!');
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

        return redirect()->route('profile.edit')->with('status', 'Password berhasil diperbarui!');
    }

    public function showProfile()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('profile.show', compact('mahasiswa'));
    }

    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user = Auth::guard('mahasiswa')->user();

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }
        return redirect()->route('profile.edit')->with('status', 'Foto profil berhasil diperbarui!');
    }
    public function deleteProfilePicture(Request $request)
    {
        $user = Auth::guard('mahasiswa')->user();
        $user->profile_picture = null;
        $user->save();
        return redirect()->route('profile.edit')->with('status', 'Foto profil berhasil dihapus!');
    }
}
