<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Menampilkan Halaman Form Register
    public function create()
    {
        return view('register'); 
    }

    // Memproses Data Pendaftaran
    public function store(Request $request)
    {
        // 1. Validasi super ketat
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20', // Wajib diisi!
            'address' => 'required|string',      // Wajib diisi!
            'password' => 'required|string|min:8|confirmed',
        ], [
            // Pesan error custom dalam bahasa Indonesia
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.'
        ]);

        // 2. Simpan ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'pelanggan' // Default selalu pelanggan baru
        ]);

        // 3. Catat di CCTV Sistem (Aktivitas Log)
        \App\Models\ActivityLog::record(
            'User Baru', 
            "Pelanggan baru mendaftar dengan nama: {$user->name} (Email: {$user->email})"
        );

        // 4. Langsung Login-kan otomatis
        Auth::login($user);

        // 5. Lempar ke katalog
        return redirect('/katalog')->with('sukses', 'Selamat datang di Yukostum! Akun Anda berhasil dibuat.');
    }
}