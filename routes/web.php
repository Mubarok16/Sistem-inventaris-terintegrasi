<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('BlankPage');
// });

// routes for authentication
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// routes for dashboard admin
Route::middleware(['auth'])->group(function () {
    // dashboard utama user
    Route::get('/dashboard/admin', [DashboardController::class, 'admin']);

    Route::get('/dashboard/pimpinan', [DashboardController::class, 'pimpinan']);
    Route::get('/dashboard/kaprodi', [DashboardController::class, 'kaprodi']);
});

// routes for dashboard peminjam (mahasiswa)
Route::middleware(['auth:peminjam'])->group(function () {
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa']);
    
    //route untuk halaman content dashboard mahasiswa
    Route::get('/dashboard/mahasiswa/peminjaman-barang', [DashboardController::class, 'mahasiswaPeminjamanBarang']);
    Route::get('/dashboard/mahasiswa/peminjaman-ruang', [DashboardController::class, 'mahasiswaPeminjamanRuang']);
    Route::get('/dashboard/mahasiswa/list-peminjaman', [DashboardController::class, 'mahasiswaListPeminjaman']);
    Route::get('/dashboard/mahasiswa/riwayat', [DashboardController::class, 'mahasiswaRiwayat']);
});