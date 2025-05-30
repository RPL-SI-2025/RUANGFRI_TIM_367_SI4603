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
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
}
