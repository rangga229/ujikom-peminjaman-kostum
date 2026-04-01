<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CostumeController;

// Rute untuk Manajemen Kostum
Route::get('/admin/kostum', [CostumeController::class, 'index']);
Route::post('/admin/kostum', [CostumeController::class, 'store']);

Route::get('/', function () {
    return view('welcome');
});
