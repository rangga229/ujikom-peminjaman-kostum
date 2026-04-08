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

            // Semua role langsung diarahkan ke Dashboard masing-masing
            return redirect('/dashboard')->with('sukses', 'Selamat datang kembali!'); 
        }

        return back()->withErrors(['email' => 'Email atau Kata Sandi salah!']);
    }

    // Memproses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('sukses', 'Anda telah berhasil keluar dari sistem.');
    }
}