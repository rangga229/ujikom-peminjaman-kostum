<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume; // Memanggil model Kostum

class KatalogController extends Controller
{
    // 1. Menampilkan Halaman Depan Katalog (Semua Kostum)
    public function index(Request $request)
    {
        // 1. Siapkan mesin pencari
        $query = Costume::query();

        // 2. Jika ada ketikan di kolom pencarian 'nama'
        if ($request->has('cari') && $request->cari != '') {
            $query->where('name', 'like', '%' . $request->cari . '%');
        }

        // 3. Jika pengguna memilih filter 'tipe'
        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('type', $request->tipe);
        }

        // 4. Ambil data dengan pembagian halaman (pagination)
        $costumes = $query->paginate(12);

        // 5. Lempar ke tampilan
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