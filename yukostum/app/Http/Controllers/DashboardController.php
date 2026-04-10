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
    public function index(Request $request)
    {
        $user = Auth::user();

        // ========================================================
        // 🛣️ CABANG 1: JIKA YANG LOGIN ADALAH PELANGGAN
        // ========================================================
        if ($user->role == 'pelanggan') {
            $menunggu = Rental::where('user_id', $user->id)->where('status', 'pending')->count();
            $sedangDisewa = Rental::where('user_id', $user->id)->where('status', 'disetujui')->count();
            $selesai = Rental::where('user_id', $user->id)->whereIn('status', ['dikembalikan', 'selesai'])->count();

            $pesananAktif = Rental::with('costume')
                            ->where('user_id', $user->id)
                            ->whereIn('status', ['pending', 'disetujui'])
                            ->orderBy('created_at', 'desc')
                            ->first();

            return view('dashboard', compact('menunggu', 'sedangDisewa', 'selesai', 'pesananAktif'));
        }

        // ========================================================
        // 🛣️ CABANG 2: JIKA YANG LOGIN ADALAH ADMIN ATAU PETUGAS
        // ========================================================
        
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        // 1. Hitung Total Stok Tersedia
        $totalStok = Costume::sum('stock');

        // 2. Hitung Jumlah Transaksi Bulan Ini
        $totalTransaksi = Rental::whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->count();

        // 3. 🌟 BARU: Cari Daftar Top 5 Kostum Paling Laris
        $kostumTerlarisList = Rental::with('costume') // Ambil relasi nama bajunya
            ->select('costume_id', DB::raw('count(*) as total_sewa'))
            ->whereMonth('created_at', $bulanIni)
            ->whereYear('created_at', $tahunIni)
            ->groupBy('costume_id')
            ->orderBy('total_sewa', 'desc')
            ->take(5) // Ambil 5 peringkat teratas
            ->get();

        // 4. 🌟 BARU: Filter Total Pendapatan (Sewa + Denda)
        $filterPendapatan = $request->query('filter', 'bulan'); 
        
        // Hanya hitung pesanan yang sudah selesai (uang sudah masuk kas)
        $queryPendapatan = Rental::where('status', 'dikembalikan'); 

        if ($filterPendapatan == 'minggu') {
            $queryPendapatan->where('updated_at', '>=', Carbon::now()->subDays(7));
            $labelPendapatan = '7 Hari Terakhir';
        } else {
            // Default filter adalah bulan ini
            $queryPendapatan->whereMonth('updated_at', $bulanIni)->whereYear('updated_at', $tahunIni);
            $labelPendapatan = 'Bulan Ini';
        }

        // Jumlahkan Harga Sewa + Denda
        $totalPendapatan = $queryPendapatan->sum('total_price') + $queryPendapatan->sum('denda');

        // Lempar semua data ke tampilan admin
        return view('admin.dashboard', compact(
            'totalStok', 
            'totalTransaksi', 
            'kostumTerlarisList', 
            'totalPendapatan', 
            'filterPendapatan', 
            'labelPendapatan'
        ));
    }
}