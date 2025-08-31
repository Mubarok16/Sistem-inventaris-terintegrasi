<?php

use App\Http\Controllers\AuthContoller;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('BlankPage');
// });

// routes for authentication
Route::get('/', [AuthContoller::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/', [AuthContoller::class, 'login']);
Route::post('/logout', [AuthContoller::class, 'logout'])->name('logout');


// routes for dashboard mhs
Route::get('/dashboard/mahasiswa', [DashboardController::class, 'dashboardMhs'])->middleware('auth');
// routes for dashboard admin
Route::get('/dashboard/admin', [DashboardController::class, 'dashboardAdmin'])->middleware('auth');



