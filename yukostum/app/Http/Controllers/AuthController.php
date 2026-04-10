<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }

    // Memproses data login
    public function prosesLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            //  LOG AKTIVITAS: Rekam saat pengguna berhasil masuk
            \App\Models\ActivityLog::record('Login Sistem', "Pengguna '" . Auth::user()->name . "' (" . Auth::user()->role . ") berhasil masuk ke sistem.");

            // Semua role langsung diarahkan ke Dashboard masing-masing
            return redirect('/dashboard')->with('sukses', 'Selamat datang kembali!'); 
        }

        // Catatan: Kita tidak mencatat log gagal login di database karena bisa membuat database cepat penuh jika ada serangan spam.
        return back()->withErrors(['email' => 'Email atau Kata Sandi salah!']);
    }

    // Memproses logout
    public function logout(Request $request)
    {
        //  LOG AKTIVITAS: Rekam SEBELUM Auth::logout() agar sistem masih tahu siapa yang sedang keluar
        if (Auth::check()) {
            \App\Models\ActivityLog::record('Logout Sistem', "Pengguna '" . Auth::user()->name . "' telah keluar dari sistem.");
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('sukses', 'Anda telah berhasil keluar dari sistem.');
    }
}