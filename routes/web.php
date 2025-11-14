<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateAkun;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditAkun;
use App\Http\Controllers\HapusAkun;
use App\Http\Controllers\PengelolaanRuangan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('BlankPage');
// });

// routes for authentication
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest'); // menampilkan halaman login
Route::post('/', [AuthController::class, 'login'])->middleware('guest'); // proses login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // proses logout

// route for create akun peminjam (mahasiswa)
Route::get('/create-akun-peminjam', [CreateAkun::class, 'showCreateAkunFormPeminjam'])->middleware('guest'); // menampilkan halaman buat akun peminjam
Route::post('/daftar', [CreateAkun::class, 'simpanAkunPeminjam'])->name('daftar')->middleware('guest');

// routes for dashboard admin
Route::middleware(['auth'])->group(function () {
    // dashboard admin
    Route::get('/dashboard/admin', [DashboardController::class, 'admin']);
    Route::get('/dashboard/admin/pengelolaan-user', [DashboardController::class, 'AdminPengelolaanUser']);
    Route::get('/dashboard/admin/pengajuan-peminjaman', [DashboardController::class, 'AdminPengajuanPeminjaman']);
    Route::get('/dashboard/admin/data-barang', [DashboardController::class, 'AdminDataBarang']);
    Route::get('/dashboard/admin/data-ruangan', [DashboardController::class, 'AdminDataRuangan']);
    Route::get('/dashboard/admin/agenda', [DashboardController::class, 'AdminAgenda']);
    Route::get('/dashboard/admin/pengadaan-barang', [DashboardController::class, 'AdminPengadaanBarang']);
    // page pengeloaan user
    Route::post('/daftar-akun-admin', [CreateAkun::class, 'simpanAkunAdmin'])->name('addAkunAdmin');
    Route::post('/edit-akun/{id}', [EditAkun::class, 'EditAkunUser']);
    Route::post('/hapus-akun/{id}', [HapusAkun::class, 'HapusAkunAdmin']);

    Route::post('/tambah-akun-peminjam', [CreateAkun::class, 'showCreateAkunPeminjamFormAdmin'])->name('addAkunPeminjam');
    Route::post('/admin/edit-akun-peminjam/{id}', [EditAkun::class, 'EditAkunPeminjam']);
    Route::post('/admin/hapus-akun-peminjam/{id}', [HapusAkun::class, 'HapusAkunPeminjam']);
    // pengelolaan ruangan
    Route::post('admin/tambah-tipe-ruangan', [PengelolaanRuangan::class, 'simpanTipeRuangan'])->name('addTipeRuangan');
    Route::post('/admin/edit-tipe-ruangan/{id}', [PengelolaanRuangan::class, 'editTipeRuangan']);
    Route::post('/admin/delete-tipe-ruangan/{id}', [PengelolaanRuangan::class, 'hapusTipeRuangan']);



    // -----------------------------------------------------------------------------------------------------


    // dashboard pimpinan fakultas
    Route::get('/dashboard/pimpinan', [DashboardController::class, 'pimpinan']);

    // -----------------------------------------------------------------------------------------------------


    // dashboard kaprodi
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
