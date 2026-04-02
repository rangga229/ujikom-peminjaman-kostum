<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CostumeController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| AREA PUBLIK (Bebas Diakses Siapapun Tanpa Login)
|--------------------------------------------------------------------------
*/

// Jika buka website awal, langsung arahkan ke Katalog
Route::get('/', function () {
    return redirect('/login');
});

// Halaman Katalog (Etalase Toko)
Route::get('/katalog', [KatalogController::class, 'index']);

Route::get('/katalog/{id}', [KatalogController::class, 'show']);

// Halaman Login & Prosesnya
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'prosesLogin']);


/*
|--------------------------------------------------------------------------
| AREA TERKUNCI (Wajib Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    // dialihkan ke katalog setelah login
    Route::get('/katalog', [KatalogController::class, 'index']);

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

    // --- FITUR PELANGGAN (Menyewa Baju) ---
    Route::get('/sewa/{id}', [RentalController::class, 'create']);
    Route::post('/sewa/{id}', [RentalController::class, 'store']);

    // --- FITUR PELANGGAN (Sewa Baju) ---
    Route::get('/sewa/{id}', [RentalController::class, 'create']);
    Route::post('/sewa/{id}', [RentalController::class, 'store']);
    
    // Baris untuk riwayat pelanggan:
    Route::get('/riwayat', [RentalController::class, 'indexPelanggan']);

});