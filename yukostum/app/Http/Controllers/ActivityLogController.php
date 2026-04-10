<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        //  SATPAM: Pastikan HANYA Admin yang bisa melihat CCTV ini
        if (Auth::user()->role !== 'admin') {
            return redirect('/dashboard')->with('error', 'Akses ditolak! Hanya Admin Utama yang bisa melihat Log Aktivitas.');
        }

        // Ambil data log, urutkan dari yang paling baru, batasi 15 per halaman
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        
        return view('admin.logs', compact('logs'));
    }
}