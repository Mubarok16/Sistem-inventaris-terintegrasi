<?php

use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('BlankPage');
// });

// routes for authentication
Route::get('/', [AuthContoller::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/', [AuthContoller::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthContoller::class, 'logout'])->name('logout');

// routes for dashboard admin and mahasiswa
Route::middleware(['auth'])->group(function () {
    // dashboard utama user
    Route::get('/dashboard/admin', [DashboardController::class, 'admin']);
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa']);

    //route untuk halaman content dashboard mahasiswa
    Route::get('/dashboard/mahasiswa/peminjaman-barang', [DashboardController::class, 'mahasiswaPeminjamanBarang']);
    Route::get('/dashboard/mahasiswa/peminjaman-ruang', [DashboardController::class, 'mahasiswaPeminjamanRuang']);
    Route::get('/dashboard/mahasiswa/list-peminjaman', [DashboardController::class, 'mahasiswaListPeminjaman']);
    Route::get('/dashboard/mahasiswa/riwayat', [DashboardController::class, 'mahasiswaRiwayat']);
});



