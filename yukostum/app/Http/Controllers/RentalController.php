<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // 🌟 TAMBAHAN: Pustaka untuk menghitung selisih tanggal

class RentalController extends Controller
{
    // 1. Menampilkan halaman formulir pilih tanggal
    public function create($id)
    {
        $costume = Costume::findOrFail($id);
        return view('sewa', compact('costume'));
    }

    // 2. Memproses pesanan masuk ke database (🌟 SUDAH DIUPDATE)
    public function store(Request $request, $id)
    {
        // Validasi agar tanggal kembali tidak lebih cepat dari tanggal pinjam
        $request->validate([
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $costume = Costume::findOrFail($id);

        // 🚨 PROTEKSI 1: Cek Kondisi Baju (Rusak / Diperbaiki)
        $kondisi = strtolower($costume->condition);
        if ($kondisi == 'rusak' || $kondisi == 'diperbaiki') {
            return back()->with('error', 'Transaksi dibatalkan. Kostum sedang dalam kondisi ' . $costume->condition . ' dan tidak bisa disewa.');
        }

        // 🚨 PROTEKSI 2: Cek Ketersediaan Stok
        if ($costume->stock < 1) {
            return back()->with('error', 'Maaf, stok kostum ini sedang kosong.');
        }

        // 🧮 LOGIKA KALKULATOR: Hitung Durasi dan Total Bayar
        $tanggalPinjam = Carbon::parse($request->borrow_date);
        $tanggalKembali = Carbon::parse($request->return_date);

        // Menghitung selisih hari. Jika pinjam dan kembali di hari yang sama, dihitung minimal 1 hari.
        $durasiHari = $tanggalPinjam->diffInDays($tanggalKembali);
        if ($durasiHari == 0) {
            $durasiHari = 1;
        }

        // Rumus: (Durasi Hari) x (Harga Kostum)
        $totalBayar = $durasiHari * $costume->price;

        // Simpan ke database
        Rental::create([
            'user_id' => Auth::id(), // ID Pelanggan yang sedang login
            'costume_id' => $id, // ID Baju yang dipinjam
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'total_price' => $totalBayar, // 🌟 TAMBAHAN: Hasil perkalian masuk ke database
            'status' => 'pending', // Status awal selalu pending
        ]);

        // Kembalikan ke katalog dengan pesan sukses dan info harga
        return redirect('/katalog')->with('sukses', 'Hore! Permintaan sewa berhasil dikirim. Total bayar: Rp ' . number_format($totalBayar, 0, ',', '.') . '. Silakan tunggu persetujuan Admin.');
    }

    // 3. (Khusus Admin) Menampilkan daftar semua pesanan
    public function indexAdmin()
    {
        // Ambil data sewa, urutkan dari yang paling baru
        $rentals = Rental::with(['user', 'costume'])->orderBy('created_at', 'desc')->get();
        return view('admin.sewa', compact('rentals'));
    }

    // 4. (Khusus Admin/Petugas) Mengubah status pesanan, Denda, dan Update Stok
    public function updateStatus(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $costume = $rental->costume; 

        $statusLama = $rental->status;
        $inputStatus = strtolower(trim($request->status));
        $statusDatabase = $inputStatus; 

        if ($inputStatus == 'approved' || $inputStatus == 'disetujui') {
            $statusDatabase = 'disetujui';
        } elseif ($inputStatus == 'completed' || $inputStatus == 'selesai' || $inputStatus == 'dikembalikan') {
            $statusDatabase = 'dikembalikan'; 
        } elseif ($inputStatus == 'cancelled' || $inputStatus == 'ditolak') {
            $statusDatabase = 'ditolak';
        }

        // 📦 LOGIKA SAAT DISETUJUI (Kurangi Stok)
        if ($rental->status == 'pending' && $statusDatabase == 'disetujui') {
            if ($costume->stock > 0) {
                $costume->decrement('stock'); 
            } else {
                return back()->with('error', 'Gagal menyetujui pesanan. Stok baju habis.');
            }
            $rental->update(['status' => $statusDatabase]);
        }
        
        // 📦 LOGIKA SAAT DIKEMBALIKAN (Upload Foto, Denda, & Tambah Stok)
        elseif ($rental->status == 'disetujui' && $statusDatabase == 'dikembalikan') {
            
            // 1. Validasi input file dan denda
            $request->validate([
                'denda' => 'required|numeric|min:0',
                'bukti_kembali' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kondisi_kembali' => 'required|string'
            ]);

            // 2. Proses Simpan Foto
            $namaFileBukti = null;
            if ($request->hasFile('bukti_kembali')) {
                $file = $request->file('bukti_kembali');
                $namaFileBukti = time() . '_bukti_' . $file->getClientOriginalName();
                $file->move(public_path('images/bukti'), $namaFileBukti);
            }

            // 3. Logika Pintar untuk Kostum
            if ($request->kondisi_kembali == 'rusak') {
                $costume->update(['condition' => 'rusak']); // Otomatis tandai kostum rusak di katalog
            }

            // Tambah stok kembali HANYA jika baju tidak hilang
            if ($request->kondisi_kembali != 'hilang') {
                $costume->increment('stock'); 
            }

            // 4. Simpan ke database
            $rental->update([
                'status' => $statusDatabase,
                'denda' => $request->denda,
                'bukti_kembali' => $namaFileBukti
            ]);

            // Log Aktivitas
            \App\Models\ActivityLog::record('Validasi Pengembalian', "Menyelesaikan pesanan #{$rental->id}. Denda: Rp {$request->denda}. Kondisi: {$request->kondisi_kembali}");
            
            return back()->with('sukses', 'Sip! Pengembalian berhasil divalidasi dan foto bukti tersimpan.');
        } 
        
        // LOGIKA TOLAK
        else {
            $rental->update(['status' => $statusDatabase]);
        }

        return back()->with('sukses', 'Status pesanan berhasil diperbarui.');
    }

    // 5. (Khusus Pelanggan) Menampilkan riwayat pesanan miliknya sendiri
    public function indexPelanggan()
    {
        // Cari pesanan yang user_id-nya sama dengan ID orang yang sedang login
        $rentals = Rental::with('costume')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('rentals'));
    }
}
