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
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        return view('Page_admin.dashboard-admin', compact('user'));
    }



    // --- IGNORE ---------------------------------------------------------------------------------------

    // method untuk agar pimpinan fakultas hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function pimpinan()
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        return view('Page_pimpinan.dahsboardPimpinan', compact('user'));
    }



    // --- IGNORE ---------------------------------------------------------------------------------------

    // method untuk agar kaprodi hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function kaprodi()
    {
        if (Auth::user()->hak_akses !== "kaprodi") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        return view('Page_kaprodi.dashboardKaprodi', compact('user'));
    }



    // --- IGNORE ---------------------------------------------------------------------------------------

    // method untuk agar mahasiswa hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function mahasiswa()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentDashbord'; // variable untuk menampilkan content dashboard
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }

    // method untuk menampilkan semua halaman dashboard mahasiswa
    public function mahasiswaPeminjamanBarang()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentPeminjamanBarang'; // variable untuk menampilkan content peminjaman barang
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }
    public function mahasiswaPeminjamanRuang()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentPeminjamanRuang'; // variable untuk menampilkan content peminjaman ruang
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }
    public function mahasiswaListPeminjaman()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentListPeminjaman'; // variable untuk menampilkan content list peminjaman
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }
    public function mahasiswaRiwayat()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentRiwayat'; // variable untuk menampilkan content riwayat
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }
    

}
