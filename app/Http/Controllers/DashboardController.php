<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Peminjam;
use App\Models\TipeRuangan;
use App\Models\TipeBarang;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\DataRuangan;
use App\Models\PengelolaanPeminjamanAdmin;
use Dflydev\DotAccessData\Data;
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
        $halaman = 'contentDashbord';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
    }

    public function adminPengelolaanUser()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        $AkunPeminjams = Peminjam::latest()->get();
        $AkunUsers = User::latest()->get();
        $JmlhAdmin = User::where('hak_akses', 'admin')->count();
        $halaman = 'contentPengelolaanUser';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'AkunPeminjams', 'AkunUsers', 'JmlhAdmin'));
    }

    public function adminPengajuanPeminjaman()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user()->nama;

        // $dataPengajuanPeminjaman = collect(PengelolaanPeminjamanAdmin::getRingkasanPeminjamanGabungan());

        // $dataPeminjamanApprove = $dataPengajuanPeminjaman->where('status','!=', 'diajukan')->sortByDesc('created_at');

        $halaman = 'contentPengajuanPeminjaman';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
    }

    public function adminDataBarang()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $DataRuangan = DataRuangan::get();
        $DataBarang = DB::table('items')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->join('rooms', 'items.id_room', '=', 'rooms.id_room')
            ->select('items.*', 'tipe_item.nama_tipe_item', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->latest()
            ->get();
        $DataTipeBarang = TipeBarang::get();
        $user = Auth::user()->nama;
        $halaman = 'contentDataBarang';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'DataTipeBarang', 'DataRuangan', 'DataBarang'));
    }

    public function adminDataRuangan()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $DataRuangan = DB::table('rooms')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->latest()
            ->get();
        $DataTipeRuangan = TipeRuangan::get();
        $user = Auth::user()->nama;
        $halaman = 'contentDataRuangan';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'DataTipeRuangan', 'DataRuangan'));
    }

    public function adminAgenda()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        $halaman = 'contentAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
    }

    public function adminPengadaanBarang()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        $halaman = 'contentPengadaanBarang';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
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
