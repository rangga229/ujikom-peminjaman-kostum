<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| AREA PUBLIK (Bebas Diakses Siapapun Tanpa Login)
|--------------------------------------------------------------------------
*/

// Jika buka website awal, langsung arahkan ke Login
Route::get('/', function () {
    return redirect('/login');
});

// Halaman Katalog (Etalase Toko)
Route::get('/katalog', [KatalogController::class, 'index']);
Route::get('/katalog/{id}', [KatalogController::class, 'show']);

// Halaman Login & Prosesnya
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'prosesLogin'])->middleware('guest');

// Halaman Register
Route::get('/register', [App\Http\Controllers\RegisterController::class, 'create'])->middleware('guest');
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'store'])->middleware('guest');


/*
|--------------------------------------------------------------------------
| AREA TERKUNCI (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Proses Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- FITUR ADMIN (Manajemen Kostum) ---
    Route::get('/admin/kostum', [CostumeController::class, 'index']);
    Route::post('/admin/kostum', [CostumeController::class, 'store']);
    Route::get('/admin/kostum/{id}/edit', [CostumeController::class, 'edit']);
    Route::put('/admin/kostum/{id}', [CostumeController::class, 'update']);
    Route::delete('/admin/kostum/{id}', [CostumeController::class, 'destroy']);

    // --- FITUR ADMIN (Manajemen Pesanan Sewa) ---
    Route::get('/admin/sewa', [RentalController::class, 'indexAdmin']);
    Route::put('/admin/sewa/{id}', [RentalController::class, 'updateStatus']);

    // --- FITUR ADMIN CRUD User
    Route::get('/admin/users', [UserController::class, 'index']);
    Route::post('/admin/users', [UserController::class, 'store']);
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit']);
    Route::put('/admin/users/{id}', [UserController::class, 'update']);
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy']);
    Route::get('/admin/laporan', [App\Http\Controllers\RentalController::class, 'cetakLaporan']);

    // --- FITUR PELANGGAN (Menyewa Baju) ---
    Route::get('/sewa/{id}', [RentalController::class, 'create']);
    Route::post('/sewa/{id}', [RentalController::class, 'store']);

    // --- FITUR PROFIL PENGGUNA ---
    Route::get('/profil', [App\Http\Controllers\ProfileController::class, 'edit']);
    Route::put('/profil', [App\Http\Controllers\ProfileController::class, 'update']);

    // FITUR ACTIVITY LOG
    Route::get('/admin/logs', [App\Http\Controllers\ActivityLogController::class, 'index']);

    // Baris untuk riwayat pelanggan:
    Route::get('/riwayat', [RentalController::class, 'indexPelanggan']);

    // Rute Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

});