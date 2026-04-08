<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // 1. Menampilkan halaman form edit profil
    public function edit()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    // 2. Memproses update data ke database
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data yang diinput
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            // Password opsional (hanya diisi jika ingin ganti password)
            'password' => 'nullable|string|min:8|confirmed',
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'password.min' => 'Kata sandi minimal 8 karakter.'
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Jika form password diisi, maka update password-nya juga
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Simpan perubahan ke database
        $user->save();

        return back()->with('sukses', 'Sip! Profil Anda berhasil diperbarui.');
    }
}