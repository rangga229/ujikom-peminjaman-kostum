<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    // 1. Menampilkan halaman formulir pilih tanggal
    public function create($id)
    {
        $costume = Costume::findOrFail($id);
        return view('sewa', compact('costume'));
    }

    // 2. Memproses pesanan masuk ke database
    public function store(Request $request, $id)
    {
        // Validasi agar tanggal kembali tidak lebih cepat dari tanggal pinjam
        $request->validate([
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        // Simpan ke database
        Rental::create([
            'user_id' => Auth::id(), // ID Pelanggan yang sedang login
            'costume_id' => $id, // ID Baju yang dipinjam
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status' => 'pending', // Status awal selalu pending
        ]);

        // Kembalikan ke katalog dengan pesan sukses
        return redirect('/katalog')->with('sukses', 'Hore! Permintaan sewa berhasil dikirim. Silakan tunggu persetujuan Admin.');
    }

    // 3. (Khusus Admin) Menampilkan daftar semua pesanan
    public function indexAdmin()
    {
        // Ambil data sewa, urutkan dari yang paling baru
        $rentals = Rental::with(['user', 'costume'])->orderBy('created_at', 'desc')->get();
        return view('admin.sewa', compact('rentals'));
    }

    // 4. (Khusus Admin) Mengubah status pesanan (Setujui/Tolak/Selesai)
    public function updateStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->update(['status' => $request->status]);

        return back()->with('sukses', 'Status pesanan berhasil diperbarui!');
    }
}