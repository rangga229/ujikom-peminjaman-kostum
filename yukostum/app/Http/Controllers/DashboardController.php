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
        $user = Auth::user();

        // ========================================================
        // 🛣️ CABANG 1: JIKA YANG LOGIN ADALAH PELANGGAN
        // ========================================================
        if ($user->role == 'pelanggan') {
            
            // 1. Ambil angka ringkasan
            $menunggu = Rental::where('user_id', $user->id)->where('status', 'pending')->count();
            $sedangDisewa = Rental::where('user_id', $user->id)->where('status', 'disetujui')->count();
            $selesai = Rental::where('user_id', $user->id)->whereIn('status', ['dikembalikan', 'selesai'])->count();

            // 2. Ambil 1 pesanan terakhir yang sedang AKTIF
            $pesananAktif = Rental::with('costume')
                            ->where('user_id', $user->id)
                            ->whereIn('status', ['pending', 'disetujui'])
                            ->orderBy('created_at', 'desc')
                            ->first();

            // Kembalikan ke tampilan pelanggan (resources/views/dashboard.blade.php)
            return view('dashboard', compact('menunggu', 'sedangDisewa', 'selesai', 'pesananAktif'));
        }

        // ========================================================
        // 🛣️ CABANG 2: JIKA YANG LOGIN ADALAH ADMIN ATAU PETUGAS
        // ========================================================
        
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
        $kostumTerlarisData = Rental::select('costume_id', DB::raw('count(*) as total_sewa'))
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->groupBy('costume_id')
            ->orderBy('total_sewa', 'desc')
            ->first();

        if ($kostumTerlarisData) {
            $kostumTerlaris = Costume::find($kostumTerlarisData->costume_id)->name;
            $jumlahDisewa = $kostumTerlarisData->total_sewa;
        } else {
            $kostumTerlaris = "Belum ada penyewaan";
            $jumlahDisewa = 0;
        }

        // Kembalikan ke tampilan admin (resources/views/admin/dashboard.blade.php)
        return view('admin.dashboard', compact('totalStok', 'totalTransaksi', 'kostumTerlaris', 'jumlahDisewa'));
    }
}