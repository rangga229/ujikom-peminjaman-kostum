<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CostumeController;

// Rute untuk Manajemen Kostum
Route::get('/admin/kostum', [CostumeController::class, 'index']);
Route::post('/admin/kostum', [CostumeController::class, 'store']);

// Rute untuk Manajemen Kostum yang sudah ada
Route::get('/admin/kostum', [CostumeController::class, 'index']);
Route::post('/admin/kostum', [CostumeController::class, 'store']);

// 3 Rute Baru untuk Edit dan Hapus:
Route::get('/admin/kostum/{id}/edit', [CostumeController::class, 'edit']); // Buka halaman edit
Route::put('/admin/kostum/{id}', [CostumeController::class, 'update']); // Proses simpan editan
Route::delete('/admin/kostum/{id}', [CostumeController::class, 'destroy']); // Proses hapus

Route::get('/', function () {
    return view('welcome');
});
