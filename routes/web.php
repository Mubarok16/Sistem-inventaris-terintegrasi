<?php
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('BlankPage');
});

Route::get('/dashboardMhs', [DashboardController::class, 'dashboardMhs']);

Route::get('/dashboardAdmin', [DashboardController::class, 'dashboardAdmin']);
