<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Costume;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {

        if (Auth::user()->role == 'pelanggan') {
            return redirect('/katalog')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk masuk.');
        }

        // 1. Ambil data bulan dan tahun saat ini
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 2. Hitung Total Stok Keseluruhan Kostum di Gudang
        $totalStok = Costume::sum('stock');

        // 3. Hitung Jumlah Transaksi (Pesanan) KHUSUS Bulan Ini
        $totalTransaksi = Rental::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        // 4. Cari Kostum Paling Laris Bulan Ini
        // Logika: Kelompokkan transaksi berdasarkan ID kostum, hitung yang paling banyak muncul
        $kostumTerlarisData = Rental::select('costume_id', DB::raw('count(*) as total_sewa'))
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->groupBy('costume_id')
            ->orderBy('total_sewa', 'desc')
            ->first();

        // Cek apakah ada transaksi bulan ini, jika ada ambil nama kostumnya
        if ($kostumTerlarisData) {
            // Mencari nama kostum berdasarkan costume_id yang paling banyak disewa
            $kostumTerlaris = Costume::find($kostumTerlarisData->costume_id)->name;
            $jumlahDisewa = $kostumTerlarisData->total_sewa;
        } else {
            $kostumTerlaris = "Belum ada penyewaan";
            $jumlahDisewa = 0;
        }

        // 5. Kirim semua data tersebut ke halaman tampilan (View)
        return view('admin.dashboard', compact('totalStok', 'totalTransaksi', 'kostumTerlaris', 'jumlahDisewa'));
    }
}