<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    // Menampilkan halaman akun
    public function index()
    {
        $user = Auth::user();
        return view('account', compact('user'));
    }

    // Mengupdate profil dan password
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'notelp' => ['nullable', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone_number = $request->notelp;

        if ($request->filled('new_password')) {
            // Validasi Password Lama
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan salah.'])->withInput();
            }
            $user->password = Hash::make($request->new_password);
            $message = 'Profil dan Password berhasil diperbarui!';
        } else {
            $message = 'Profil berhasil diperbarui!';
        }

        /** @var \App\Models\User $user */
        $user->save();

        return back()->with('success', $message);
    }

    // Menghapus Akun
    public function destroy(Request $request)
    {
        $user = Auth::user();

        // Logout dulu
        Auth::logout();

        // Hapus data user
        /** @var \App\Models\User $user */
        $user->delete();

        // Invalidasi session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun Anda telah dihapus.');
    }
}