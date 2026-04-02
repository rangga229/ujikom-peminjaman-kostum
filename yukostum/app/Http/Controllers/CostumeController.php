<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume; // Memanggil model Costume

class CostumeController extends Controller
{
    // Menampilkan halaman daftar dan form tambah kostum
    public function index()
    {
        // Mengambil semua data kostum dari database
        $costumes = Costume::all(); 
        return view('admin.kostum', compact('costumes'));
    }

    // Menyimpan data kostum baru ke database
    public function store(Request $request)
    {
        Costume::create([
            'name' => $request->name,
            'material' => $request->material,
            'size' => $request->size,
            'color' => $request->color,
            'origin' => $request->origin,
            'type' => $request->type,
            'stock' => $request->stock,
            'condition' => $request->condition,
        ]);

        return back()->with('sukses', ' Kostum dengan detail baru berhasil ditambahkan.');
    }

    // Menampilkan halaman Edit Kostum
    public function edit($id)
    {
        $costume = Costume::findOrFail($id); // Cari kostum berdasarkan ID
        return view('admin.edit_kostum', compact('costume'));
    }

    // Menyimpan perubahan data kostum (Update)
    public function update(Request $request, $id)
    {
        $costume = Costume::findOrFail($id);
        $costume->update($request->all()); // Update semua data yang diisi

        return redirect('/admin/kostum')->with('sukses', 'Mantap! Data kostum berhasil diperbarui.');
    }

    // Menghapus data kostum (Delete)
    public function destroy($id)
    {
        $costume = Costume::findOrFail($id);
        $costume->delete();

        return redirect('/admin/kostum')->with('sukses', 'Kostum berhasil dihapus dari sistem.');
    }
}