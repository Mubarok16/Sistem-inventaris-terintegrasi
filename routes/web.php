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
    Route::get('/dashboard/admin', [DashboardController::class, 'admin']);
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa']);
});



