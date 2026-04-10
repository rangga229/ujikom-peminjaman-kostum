<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Costume; // Memanggil model Costume

class CostumeController extends Controller
{
    // 1. Menampilkan halaman daftar dan form tambah kostum
    public function index()
    {
        // Mengambil semua data kostum dari database (khusus Admin)
        $costumes = Costume::all();
        return view('admin.kostum', compact('costumes'));
    }

    // 2. Menyimpan data kostum baru ke database
    public function store(Request $request)
    {
        // Siapkan keranjang kosong untuk menampung nama-nama file foto
        $namaFotoArray = [];

        // Cek jika ada file gambar yang diunggah
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $foto) {
                // Beri nama unik agar tidak bentrok (waktu + id unik + ekstensi asli)
                $namaFoto = time() . '-' . uniqid() . '.' . $foto->getClientOriginalExtension();
                // Pindahkan file fisik ke folder public/images/kostum
                $foto->move(public_path('images/kostum'), $namaFoto);
                // Masukkan nama file ke keranjang
                $namaFotoArray[] = $namaFoto;
            }
        }

        // Simpan semua data ke database
        Costume::create([
            'name' => $request->name,
            'images' => $namaFotoArray, // Masukkan keranjang foto berformat JSON
            'type' => $request->type,
            'size' => $request->size,
            'color' => $request->color,
            'material' => $request->material,
            'stock' => $request->stock,
            'condition' => $request->condition,
            'price' => $request->price // Menyimpan harga sewa per hari
        ]);

            // 🛡️ PROTEKSI: Hanya Admin yang boleh
        if (Auth::user()->role != 'admin') {
            return back()->with('error', 'Akses Ditolak! Hanya Admin yang dapat menambah kostum.');
        }

        return back()->with('sukses', 'Kostum dengan detail baru berhasil ditambahkan.');
    }

    // 3. Menampilkan halaman Edit Kostum (Formulir dengan data lama)
    public function edit($id)
    {
        // Cari kostum berdasarkan ID, jika tidak ada akan muncul error 404
        $costume = Costume::findOrFail($id);
        return view('admin.edit_kostum', compact('costume'));
    }

    // 4. Menyimpan perubahan data kostum (Update)
    public function update(Request $request, $id)
    {
        $costume = Costume::findOrFail($id);

        // Ambil semua data isian form, KECUALI bagian foto
        $data = $request->except('images');

        // Jika Admin mengunggah foto baru saat proses edit
        if ($request->hasFile('images')) {

            // Hapus foto-foto lama secara fisik dari folder agar tidak menumpuk
            if (!empty($costume->images)) {
                foreach ($costume->images as $oldImage) {
                    $hapusPath = public_path('images/kostum/' . $oldImage);
                    // Jika file fisiknya ada, maka hapus (unlink)
                    if (file_exists($hapusPath)) {
                        unlink($hapusPath);
                    }
                }
            }

            // Upload foto-foto baru ke folder
            $namaFotoArray = [];
            foreach ($request->file('images') as $foto) {
                $namaFoto = time() . '-' . uniqid() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('images/kostum'), $namaFoto);
                $namaFotoArray[] = $namaFoto;
            }

            // Tambahkan nama-nama foto baru ke dalam paket data yang akan diupdate
            $data['images'] = $namaFotoArray;
        }

        // Timpa data lama di database dengan paket data yang baru
        $costume->update($data);

        return redirect('/admin/kostum')->with('sukses', 'Mantap! Data kostum dan foto berhasil diperbarui.');
    }

    // 5. Menghapus data kostum (Delete)
    public function destroy($id)
    {
        $costume = Costume::findOrFail($id);
        $namaKostum = $costume->name;


        // Hapus SEMUA file foto fisik milik kostum ini dari folder
        if (!empty($costume->images)) {
            foreach ($costume->images as $img) {
                $hapusPath = public_path('images/kostum/' . $img);
                if (file_exists($hapusPath)) {
                    unlink($hapusPath);
                }
            }
        }

          // 🛡️ PROTEKSI: Hanya Admin yang boleh
        if (Auth::user()->role != 'admin') {
            return back()->with('error', 'Akses Ditolak! Hanya Admin yang dapat menghapus kostum.');
        }

        // Setelah file fisiknya bersih, baru hapus catatan kostum dari database MySQL
        $costume->delete();
        \App\Models\ActivityLog::record('Hapus Kostum', "Menghapus kostum bernama: $namaKostum");

        return redirect('/admin/kostum')->with('sukses', 'Kostum dan seluruh file fotonya berhasil dihapus bersih dari sistem.');
    }
}
