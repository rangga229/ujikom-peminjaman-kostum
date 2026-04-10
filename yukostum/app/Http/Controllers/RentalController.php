<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 

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
        $request->validate([
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $costume = Costume::findOrFail($id);

        $kondisi = strtolower($costume->condition);
        if ($kondisi == 'rusak' || $kondisi == 'diperbaiki') {
            return back()->with('error', 'Transaksi dibatalkan. Kostum sedang dalam kondisi ' . $costume->condition . ' dan tidak bisa disewa.');
        }

        if ($costume->stock < 1) {
            return back()->with('error', 'Maaf, stok kostum ini sedang kosong.');
        }

        $tanggalPinjam = Carbon::parse($request->borrow_date);
        $tanggalKembali = Carbon::parse($request->return_date);

        $durasiHari = $tanggalPinjam->diffInDays($tanggalKembali);
        if ($durasiHari == 0) {
            $durasiHari = 1;
        }

        $totalBayar = $durasiHari * $costume->price;

        $rental = Rental::create([
            'user_id' => Auth::id(), 
            'costume_id' => $id, 
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'total_price' => $totalBayar, 
            'status' => 'belum_bayar', 
        ]);

        //  LOG AKTIVITAS: Pelanggan mulai membuat pesanan
        \App\Models\ActivityLog::record('Mulai Pesanan Baru', "Pelanggan membuat draf pesanan #ORD-00{$rental->id} (Status: Belum Bayar).");

        return redirect('/sewa/bayar/' . $rental->id);
    }

    // 1. Menampilkan Halaman Pembayaran & Ringkasan
    public function halamanBayar($id)
    {
        $rental = Rental::with('costume')->findOrFail($id);
        
        $borrow = Carbon::parse($rental->borrow_date);
        $return = Carbon::parse($rental->return_date);
        $durasi = $borrow->diffInDays($return) ?: 1; 

        return view('bayar', compact('rental', 'durasi'));
    }

    // 2. Memproses Tombol "Bayar Sekarang"
    public function prosesBayar(Request $request, $id)
    {
        //  LOG AKTIVITAS: Pelanggan masuk ke tahap pembayaran
        \App\Models\ActivityLog::record('Proses Pembayaran', "Pelanggan memproses pembayaran untuk pesanan #ORD-00{$id}.");
        
        return redirect('/sewa/konfirmasi/' . $id);
    }

    // 3. Menampilkan Halaman Konfirmasi (Nomor Pesanan)
    public function halamanKonfirmasi($id)
    {
        $rental = Rental::with('costume')->findOrFail($id);
        return view('konfirmasi', compact('rental'));
    }

    // 4. Memproses Tombol "Ajukan"
    public function ajukanPesanan($id)
    {
        $rental = Rental::findOrFail($id);
        $rental->update(['status' => 'pending']); 
        
        //  LOG AKTIVITAS: Pelanggan resmi mengajukan pesanan
        \App\Models\ActivityLog::record('Pesanan Diajukan', "Pesanan #ORD-00{$rental->id} diajukan dan sedang menunggu persetujuan Admin.");

        return redirect('/dashboard')->with('sukses', 'Pesanan berhasil diajukan! Silakan tunggu persetujuan dari Admin.');
    }

    // 3. (Khusus Admin) Menampilkan daftar semua pesanan
    public function indexAdmin()
    {
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

        // 📦 LOGIKA SAAT DISETUJUI
        if ($rental->status == 'pending' && $statusDatabase == 'disetujui') {
            if ($costume->stock > 0) {
                $costume->decrement('stock'); 
            } else {
                return back()->with('error', 'Gagal menyetujui pesanan. Stok baju habis.');
            }
            $rental->update(['status' => $statusDatabase]);

            //  LOG AKTIVITAS: Pesanan Disetujui
            \App\Models\ActivityLog::record('Setujui Pesanan', "Pesanan #ORD-00{$rental->id} disetujui. Stok kostum '{$costume->name}' otomatis dikurangi.");
        }
        
        // 📦 LOGIKA SAAT DIKEMBALIKAN 
        elseif ($rental->status == 'disetujui' && $statusDatabase == 'dikembalikan') {
            
            $request->validate([
                'denda' => 'required|numeric|min:0',
                'bukti_kembali' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kondisi_kembali' => 'required|string'
            ]);

            $namaFileBukti = null;
            if ($request->hasFile('bukti_kembali')) {
                $file = $request->file('bukti_kembali');
                $namaFileBukti = time() . '_bukti_' . $file->getClientOriginalName();
                $file->move(public_path('images/bukti'), $namaFileBukti);
            }

            if ($request->kondisi_kembali == 'rusak') {
                $costume->update(['condition' => 'rusak']); 
            }

            if ($request->kondisi_kembali != 'hilang') {
                $costume->increment('stock'); 
            }

            $rental->update([
                'status' => $statusDatabase,
                'denda' => $request->denda,
                'bukti_kembali' => $namaFileBukti
            ]);

            //  LOG AKTIVITAS: Validasi Pengembalian
            \App\Models\ActivityLog::record('Validasi Pengembalian', "Menyelesaikan pesanan #ORD-00{$rental->id}. Denda: Rp {$request->denda}. Kondisi: {$request->kondisi_kembali}");
            
            return back()->with('sukses', 'Sip! Pengembalian berhasil divalidasi dan foto bukti tersimpan.');
        } 
        
        // LOGIKA TOLAK
        else {
            $rental->update(['status' => $statusDatabase]);

            //  LOG AKTIVITAS: Pesanan Ditolak
            if ($statusDatabase == 'ditolak') {
                \App\Models\ActivityLog::record('Tolak Pesanan', "Pesanan #ORD-00{$rental->id} telah ditolak.");
            }
        }

        return back()->with('sukses', 'Status pesanan berhasil diperbarui.');
    }

    // 5. (Khusus Pelanggan) Menampilkan riwayat pesanan miliknya sendiri
    public function indexPelanggan()
    {
        $rentals = Rental::with('costume')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayat', compact('rentals'));
    }

    // 6. (Khusus Admin/Petugas) Mencetak Laporan Pemasukan
    public function cetakLaporan()
    {
        $rentals = Rental::with(['user', 'costume'])
                    ->where('status', 'dikembalikan')
                    ->orderBy('updated_at', 'desc')
                    ->get();

        $totalSewa = $rentals->sum('total_price');
        $totalDenda = $rentals->sum('denda');
        $grandTotal = $totalSewa + $totalDenda;

        //  LOG AKTIVITAS: Laporan Dicetak
        \App\Models\ActivityLog::record('Cetak Laporan', "Mencetak laporan pendapatan total Rp " . number_format($grandTotal, 0, ',', '.'));

        return view('admin.laporan', compact('rentals', 'totalSewa', 'totalDenda', 'grandTotal'));
    }
}