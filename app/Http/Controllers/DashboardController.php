<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// class return view dashboard
class DashboardController extends Controller
{
    // method untuk agar admin hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function admin()
    {
        if (Auth::user()->hak_akses !== 1) {
            abort(403, 'Unauthorized');
        }
        return view('Page_admin.dashboard-admin');
    }
    

    // method untuk agar mahasiswa hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function mahasiswa()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        $halaman = 'contentDashbord'; // variable untuk menampilkan content dashboard
        return view('Page_mhs.dashboardMhs', compact('halaman'));
    }

    // method untuk menampilkan semua halaman dashboard mahasiswa
    public function mahasiswaPeminjamanBarang()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        $halaman = 'contentPeminjamanBarang'; // variable untuk menampilkan content peminjaman barang
        return view('Page_mhs.dashboardMhs', compact('halaman'));
    }
    public function mahasiswaPeminjamanRuang()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        $halaman = 'contentPeminjamanRuang'; // variable untuk menampilkan content peminjaman ruang
        return view('Page_mhs.dashboardMhs', compact('halaman'));
    }
    public function mahasiswaListPeminjaman()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        $halaman = 'contentListPeminjaman'; // variable untuk menampilkan content list peminjaman
        return view('Page_mhs.dashboardMhs', compact('halaman'));
    }
    public function mahasiswaRiwayat()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        $halaman = 'contentRiwayat'; // variable untuk menampilkan content riwayat
        return view('Page_mhs.dashboardMhs', compact('halaman'));
    }
    // --- IGNORE ---


}






