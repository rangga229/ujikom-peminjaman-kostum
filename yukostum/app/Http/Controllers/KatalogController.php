<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume; // Memanggil model Kostum

class KatalogController extends Controller
{
    // 1. Menampilkan Halaman Depan Katalog (Semua Kostum)
    public function index()
    {
        // Mengambil semua data kostum dari database, diurutkan dari yang terbaru
        $costumes = Costume::orderBy('created_at', 'desc')->get();
        
        return view('katalog', compact('costumes'));
    }

    // 2. Menampilkan Halaman Detail untuk Satu Kostum (Fitur Baru)
    public function show($id)
    {
        // Mencari kostum berdasarkan ID. Jika tidak ada, otomatis error 404.
        $costume = Costume::findOrFail($id);
        
        // Membawa data kostum tersebut ke halaman detail.blade.php
        return view('detail', compact('costume'));
    }
}