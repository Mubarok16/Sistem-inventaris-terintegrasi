<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CreateAkun;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditAkun;
use App\Http\Controllers\HapusAkun;
use App\Http\Controllers\mahasiswa\calenderController;
use App\Http\Controllers\mahasiswa\peminjamanbarangController;
use App\Http\Controllers\mahasiswa\peminjamanRuanganController;
use App\Http\Controllers\mahasiswa\PengajuanPeminjamanController;
use App\Http\Controllers\mahasiswa\RiwayarController;
use App\Http\Controllers\pengelolaanAgenda;
use App\Http\Controllers\PengelolaanRuangan;
use App\Http\Controllers\PengelolaanBarang;
use App\Http\Controllers\PengelolaanPeminjamanAdmin;
use App\Http\Controllers\PengelolaanUserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// routes for authentication
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest'); // menampilkan halaman login
Route::post('/', [AuthController::class, 'login'])->middleware('guest'); // proses login
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // proses logout

// route for create akun peminjam (mahasiswa)
Route::get('/create-akun-peminjam', [CreateAkun::class, 'showCreateAkunFormPeminjam'])->middleware('guest'); // menampilkan halaman buat akun peminjam
Route::post('/daftar', [CreateAkun::class, 'simpanAkunPeminjam'])->name('daftar')->middleware('guest');

// mengambil data agenda dan peminjaman kemudian memasukkan ke calender di dashboard
// Route::get('/events-calender', [calenderController::class, 'calender']);

// agenda detail agenda di calender
// Route::get('/dashboard/mahasiswa/agenda/{id}/{date}', [DashboardController::class, 'mahasiswaAgenda'])->name('agenda-mhs');

// URL: /peminjam/dashboard
Route::middleware(['auth:peminjam'])->prefix('peminjam')->group(function () {
    Route::get('/events-calender', [calenderController::class, 'calender']);
});
// URL: /admin/dashboard
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/events-calender', [calenderController::class, 'calender']);
});

Route::prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard/agenda/{id}/{date}', [DashboardController::class, 'adminDetailAgenda'])->name('agenda-calender');
});

Route::prefix('peminjam')->as('peminjam.')->group(function () {
    Route::get('/dashboard/agenda/{id}/{date}', [DashboardController::class, 'mahasiswaAgenda'])->name('agenda-calender');
});


// routes for dashboard admin
Route::middleware(['auth'])->group(function () {

    // dashboard admin
    Route::get('/dashboard/admin', [DashboardController::class, 'admin']);
    Route::get('/dashboard/admin/pengelolaan-user', [DashboardController::class, 'AdminPengelolaanUser'])->name('pengelolaan-user');
    Route::get('/dashboard/admin/pengajuan-peminjaman', [DashboardController::class, 'AdminPengajuanPeminjaman'])->name('admin.pengajuan.peminjaman');
    Route::get('/dashboard/admin/data-barang', [DashboardController::class, 'AdminDataBarang'])->name('peng-barang');
    Route::get('/dashboard/admin/data-ruangan', [DashboardController::class, 'AdminDataRuangan'])->name('peng-ruang');
    Route::get('/dashboard/admin/agenda', [DashboardController::class, 'AdminAgenda'])->name('dashboard-admin-agenda');
    Route::get('/dashboard/admin/pengadaan-barang', [DashboardController::class, 'AdminPengadaanBarang']);

    // page pengeloaan user ================================================================================================================

    // page edit akun all
    Route::get('/dashboard/admin/edit-akun/{id}', [EditAkun::class, 'editAkun'])->name('page-edit-akun');
    // page add akun all
    Route::get('/dashboard/admin/add-akun-all/', [CreateAkun::class, 'buatAkunPenggunaByAdmin'])->name('page-buat-akun-by-admin');

    // fungsi crud users
    Route::post('/daftar-akun-admin', [CreateAkun::class, 'simpanAkunAdmin'])->name('addAkunAdmin');
    Route::post('/edit-akun-users/{id}', [EditAkun::class, 'EditAkunUser'])->name('edit-akun-users');
    Route::post('/hapus-akun/{id}', [HapusAkun::class, 'HapusAkunAdmin'])->name('hapus-akun-users');

    // crud table mhs by admin
    Route::post('/tambah-akun-peminjam', [CreateAkun::class, 'showCreateAkunPeminjamFormAdmin'])->name('addAkunPeminjam');
    Route::post('/admin/edit-akun-peminjam/{id}', [EditAkun::class, 'EditAkunPeminjam'])->name('edit-akun-mhs');
    Route::post('/admin/hapus-akun-peminjam/', [HapusAkun::class, 'HapusAkunPeminjam'])->name('hapus-akun-mhs');

    // route fungsi filter by role
    Route::get('/dashboard/admin/pengelolaan-user/filter-role', [PengelolaanUserController::class, 'filterRole'])->name('filter-role-user');
    // route fungsi filter by status
    Route::get('/dashboard/admin/pengelolaan-user/filter-status', [PengelolaanUserController::class, 'filterStatus'])->name('filter-status-user');

    // pengelolaan ruangan ====================================================================================================================
    Route::post('admin/tambah-tipe-ruangan', [PengelolaanRuangan::class, 'simpanTipeRuangan'])->name('addTipeRuangan');
    Route::post('/admin/edit-tipe-ruangan/{id}', [PengelolaanRuangan::class, 'editTipeRuangan']);
    Route::post('/admin/delete-tipe-ruangan/{id}', [PengelolaanRuangan::class, 'hapusTipeRuangan']);
    Route::post('/admin/tambah-ruangan', [PengelolaanRuangan::class, 'tambahRuangan'])->name('addRuangan');
    Route::post('/admin/delete-ruangan/{id}', [PengelolaanRuangan::class, 'hapusRuangan']);
    Route::get('/admin/data-ruangan/edit/{id}', [PengelolaanRuangan::class, 'DetailRuangan'])->name('edit-ruangan');

    // pengelolaan barang ======================================================================================================================
    Route::post('admin/tambah-tipe-barang', [PengelolaanBarang::class, 'simpanTipeBarang'])->name('addTipeBarang');
    Route::post('/admin/edit-tipe-barang/{id}', [PengelolaanBarang::class, 'editTipeBarang']);
    Route::delete('/admin/delete-tipe-barang/{id}', [PengelolaanBarang::class, 'hapusTipeBarang']);
    Route::post('/admin/tambah-barang', [PengelolaanBarang::class, 'tambahBarang'])->name('addBarang');
    Route::delete('/admin/delete-barang/{id}', [PengelolaanBarang::class, 'hapusBarang']);
    Route::get('/admin/data-barang/edit/{id}', [PengelolaanBarang::class, 'haleditBarang'])->name('edit-barang');


    // pengelolaan peminjaman ==================================================================================================================
    Route::get('/admin/pengajuan-peminjaman/detail/{id}', [PengelolaanPeminjamanAdmin::class, 'DetailPeminjamanAdmin']);
    Route::post('admin/pengajuan-peminjaman/persetujuan', [PengelolaanPeminjamanAdmin::class, 'persetujuan'])->name('persetujuanPeminjaman');
    Route::post('admin/pengajuan-peminjaman/pilih-data-pengelolaan-peminjaman-by-status', [PengelolaanPeminjamanAdmin::class, 'pilihDataPengajuanPeminjamanAdmin'])->name('pilih-data-pengelolaan-peminjaman-by-status');

    //Pengelolaan Agenda ========================================================================================================================
    // page import agenda
    Route::get('/dashboard/admin/page-import-agenda', [pengelolaanAgenda::class, 'pageImportAgenda'])->name('dashboard-admin-page-import-agenda');
    // page detail agenda
    Route::get('/admin/detail-agenda/detail/{id}', [pengelolaanAgenda::class, 'DetailAgenda'])->name('admin-detail-agenda');
    // page tambah agenda
    Route::get('/admin/pengelolaan-agenda/tambah-agenda', [pengelolaanAgenda::class, 'HalamanTambahAgenda'])->name('hal-add-agenda');
    // page edit agenda
    Route::get('/admin/pengelolaan-agenda/edit-agenda/{id}', [pengelolaanAgenda::class, 'HalamanEditAgenda'])->name('edit-agenda-admin');
    // fungsi tambah agenda import
    Route::post('/tambah-agenda-impor', [pengelolaanAgenda::class, 'addAgendaImport'])->name('tambah-agenda-import');

    // --------------------------------------------- route untuk logika edit agenda -------------------------------------------------------------------- 
    // route fungsi temporary menambah menghapus barang dan ruang dan agenda sebelum di simpan permanen di db
    Route::post('/edit-agenda', [pengelolaanAgenda::class, 'simpanInputAgendaTemporary'])->name('edit-agenda');
    //barang
    Route::post('/tambah-barang-agenda', [pengelolaanAgenda::class, 'simpanInputBarangAgendaTemporary'])->name('tambah-barang-agenda');
    Route::post('/hapus-barang-agenda', [pengelolaanAgenda::class, 'hapusInputBarangAgendaTemporary'])->name('hapus-barang-agenda');
    //ruangan
    Route::post('/tambah-ruangan-agenda', [pengelolaanAgenda::class, 'simpanInputRuanganAgendaTemporary'])->name('tambah-ruangan-agenda');
    Route::post('/hapus-ruangan-agenda', [pengelolaanAgenda::class, 'hapusInputRuanganAgendaTemporary'])->name('hapus-ruangan-agenda');
    // simpan data temp agenda ke db
    Route::post('/simpan-agenda', [pengelolaanAgenda::class, 'simpanAgendaTemporary'])->name('simpan-agenda');
    
    // ----------------------------------------- route untuk logika tambah agenda ---------------------------------------------------------------------
    // simpan sementara data agenda unutk bagian tambah agenda
    Route::post('/kunci-agenda-temp', [pengelolaanAgenda::class, 'kunciInputTambahAgenda'])->name('kunci-agenda-tambah-agenda');
    Route::post('/kunci-barang-ruang-temp', [pengelolaanAgenda::class, 'kunciTempBarangRuangTambahAgenda'])->name('kunci-barang-ruang-tambah-agenda');
    Route::post('/hapus-barang-ruang-temp', [pengelolaanAgenda::class, 'hapusBarangRuangTemTambahAgenda'])->name('hapus-barang-ruang-tambah-agenda');
    Route::post('/simpan-tambah-agenda', [pengelolaanAgenda::class, 'simpanTambahAgendaBaru'])->name('simpan-tambah-agenda');
    // 


    // hapus data agenda db
    Route::post('/hapus-agenda', [pengelolaanAgenda::class, 'hapusAgenda'])->name('hapus-agenda');
    

    // -----------------------------------------------------------------------------------------------------


    // dashboard pimpinan fakultas
    Route::get('/dashboard/pimpinan', [DashboardController::class, 'pimpinan']);

    // -----------------------------------------------------------------------------------------------------


    // dashboard kaprodi
    Route::get('/dashboard/kaprodi', [DashboardController::class, 'kaprodi']);
});


// routes for dashboard peminjam (mahasiswa)
Route::middleware(['auth:peminjam'])->group(function () {
    // dashbord
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('dashboard-mhs');

    // mengambil data agenda dan peminjaman kemudian memasukkan ke calender di dashboard
    // Route::get('/events', [calenderController::class, 'calender']);

    //route untuk halaman content dashboard mahasiswa
    // peminjaman barang
    Route::get('/dashboard/mahasiswa/peminjaman-barang', [DashboardController::class, 'mahasiswaPeminjamanBarang'])->name('mhs-peminjaman-barang');
    // detail peminjaman barang
    Route::get('/dashboard/mahasiswa/detail-peminjaman-barang/{id}', [peminjamanbarangController::class, 'DetailPeminjamanBarang'])->name('mhs-detail-peminjaman-barang');
    // menambahkan barang ke cart
    Route::post('/dashboard/mahasiswa/add-cart-barang', [peminjamanbarangController::class, 'BarangAddCart'])->name('mahasiswa-add-cart-barang');
    // manghapus barang dari cart
    Route::post('/hapus-item-cart', [peminjamanbarangController::class, 'hapusitemcart'])->name('hapus-item-cart');
    // mengubah tanggal peminjaman barang yang dipilih
    Route::post('mahasiswa/ganti-tgl-chosed-barang', [peminjamanbarangController::class, 'gantiTgl'])->name('ganti-tgl-chosed-barang');

    // peminjaman ruang
    Route::get('/dashboard/mahasiswa/peminjaman-ruang', [DashboardController::class, 'mahasiswaPeminjamanRuang'])->name('mhs-peminjaman-ruang');
    // detail peminjaman ruang
    Route::get('/dashboard/mahasiswa/detail-peminjaman-ruang/{id}', [peminjamanRuanganController::class, 'DetailPeminjamanRuangan'])->name('mhs-detail-peminjaman-ruang');

    // menambahkan ruangan ke cart
    Route::post('/dashboard/mahasiswa/add-cart-ruangan', [peminjamanRuanganController::class, 'ruanganAddCart'])->name('mahasiswa-add-cart-ruangan');
    // manghapus barang dari cart
    Route::post('/hapus-room-cart', [peminjamanruanganController::class, 'hapusroomcart'])->name('hapus-room-cart');
    // mengubah tanggal peminjaman barang yang dipilih
    Route::post('mahasiswa/ganti-tgl-chosed-ruang', [peminjamanRuanganController::class, 'gantiTgl'])->name('ganti-tgl-chosed-ruang');

    // list peminjaman cart
    Route::get('/dashboard/mahasiswa/list-peminjaman', [DashboardController::class, 'mahasiswaListPeminjaman'])->name('mhs-list-peminjaman');
    //detail transaksi peminjaman
    Route::get('/dashboard/mahasiswa/detail-transaksi', [PengajuanPeminjamanController::class, 'mahasiswaDetailTransaksi'])->name('mhs-detail-transaksi');
    // ajukan peminjaman
    Route::post('/dashboard/mahasiswa/pengajuan-peminjaman', [PengajuanPeminjamanController::class, 'PengajuanPeminjaman'])->name('mhs-pengajuan-peminjaman');

    //riwayat
    Route::get('/dashboard/mahasiswa/riwayat', [DashboardController::class, 'mahasiswaRiwayat'])->name('mhs-riwayat');
    // detail transaksi mahasiswa
    Route::get('/dashboard/mahasiswa/riwayat/detail-riwayat/{id}', [RiwayarController::class, 'mahasiswaRiwayatDetail'])->name('mhs-riwayat-detail');
    //simpan riwayat session
    Route::post('simpan-riwayat-session-status', [RiwayarController::class, 'SimpanSessionriwayatByStatus'])->name('simpan-riwayat-session');
    // btn batal dan cetak qr user
    Route::post('cetak-QRriwayat-dan-batal-peminjaman', [RiwayarController::class, 'QrDanBatalPeminjaman'])->name('QR-dan-batal-peminjaman');
});
