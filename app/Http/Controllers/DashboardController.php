<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjam;
use App\Models\TipeRuangan;
use App\Models\TipeBarang;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\DataRuangan;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\PengelolaanPeminjamanAdmin;
use App\Models\UsageItems;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\Admin\PengelolaanPeminjamanService;

// controlller untuk halaman awal di dshboard setiap user atau peminjam
class DashboardController extends Controller
{
    // --- ADMIN/STAFF ---------------------------------------------------------------------------------------
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
        // dd($DataAgenda = DB::table('peminjam') // Pilih kolom yang diperlukan
        //     ->latest()
        //     ->get());
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
        // $dataPengajuanPeminjaman = Peminjaman::latest()->get();

        // $dataPengajuanPeminjaman = Peminjaman::join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
        //     ->leftJoin('usage_items', 'usage_items.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
        //     ->leftJoin('usage_rooms', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
        //     ->select('peminjaman.*', 'peminjam.nama_peminjam', 'usage_items.tgl_pinjam_usage_item', 'usage_items.tgl_kembali_usage_item', 'usage_rooms.tgl_pinjam_usage_room', 'usage_rooms.tgl_kembali_usage_room', 'usage_rooms.jam_mulai_usage_room', 'usage_rooms.jam_selesai_usage_room', 'usage_items.jam_mulai_usage_item', 'usage_items.jam_selesai_usage_item') // Pilih kolom yang diperlukan
        //     ->where('peminjaman.status_peminjaman', 'diajukan')
        //     ->orderBy('peminjaman.created_at', 'asc')
        //     ->get();

        // dd($dataPengajuanPeminjaman);

        $dataPeminjamanDisetujui = Peminjaman::join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            // ->join('users', 'peminjaman.id_user', '=', 'users.id_user')
            ->select('peminjaman.*', 'peminjam.nama_peminjam') // Pilih kolom yang diperlukan
            ->where('peminjaman.status_peminjaman', '!=', 'terjadwal')
            ->latest()
            ->get();
        
        // sorting data display by status peminjaman
        $status_penggunaan = null;

        if (session()->get('status-peminjaman') === null) {
            $status_penggunaan = 'semua';
        }else{
            $status_penggunaan = session()->get('status-peminjaman');
        }
        // mengambil data dari db berdasarkan status nya
        $PengelolaanPeminjamanService = new PengelolaanPeminjamanService;
        $dataPengajuanPeminjaman = $PengelolaanPeminjamanService->dataPenggunaanBarangByStatus($status_penggunaan);

        // mengambil data total Peminjaman yg sudah di terjadwal dan sedang digunakan
        $totalPeminjaman = $PengelolaanPeminjamanService->hitungTotalPeminjaman();

        // mengambil data total yg diajukan
        $totalDiajukan = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('diajukan');
        // mengambil data total yg dipinjam
        $totalDipinjam = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('dipinjam');
        // mengambil data total yg terlambat dikembalikan
        $totalTerlambat = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('terlambat');
        // dd($totalPeminjaman);

        $halaman = 'contentPengajuanPeminjaman';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataPengajuanPeminjaman', 'dataPeminjamanDisetujui', 'status_penggunaan', 'totalPeminjaman', 'totalDiajukan', 'totalDipinjam', 'totalTerlambat'));
    }

    public function adminDataBarang()
    {
        // cek jika user yg login bukan admin akan di arahkan ke halaman unauthorize
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        // mengambil data ruangan
        $DataRuangan = DataRuangan::get();
        // mengambil semua data barang dan nama tipe barang dan nama ruangan
        $DataBarang = DB::table('items')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->join('rooms', 'items.id_room', '=', 'rooms.id_room')
            ->select('items.*', 'tipe_item.nama_tipe_item', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->latest()
            ->get();
        // mengambil data tipe barang
        $DataTipeBarang = TipeBarang::get();
        // mengambil data user yang sedang login
        $user = Auth::user()->nama;
        // membuat variable dengan isi content data barang
        $halaman = 'contentDataBarang';
        // mengirimkan view ke halaman dahsboard pengelolaan barang dengan mengirimkan variable yg di butuhkan di halaman
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

        $DataAgenda = DB::table('agenda_fakultas') // Pilih kolom yang diperlukan
            ->latest()
            ->get();

        $user = Auth::user()->nama;
        $halaman = 'contentAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'DataAgenda'));
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



    // --- PIMPINAN ---------------------------------------------------------------------------------------

    // method untuk agar pimpinan fakultas hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function pimpinan()
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        return view('Page_pimpinan.dahsboardPimpinan', compact('user'));
    }



    // --- KAPRODI ---------------------------------------------------------------------------------------

    // method untuk agar kaprodi hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function kaprodi()
    {
        if (Auth::user()->hak_akses !== "kaprodi") {
            abort(403, 'Unauthorized');
        }
        $user = Auth::user()->nama;
        return view('Page_kaprodi.dashboardKaprodi', compact('user'));
    }



    // --- MAHASISWA ---------------------------------------------------------------------------------------

    // method untuk agar mahasiswa hanya bisa mengakses halaman sesuai dengan hak aksesnya

    // memanggil halaman dashboard peminjam(mahasiswa)
    public function mahasiswa()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentDashbord'; // variable untuk menampilkan content dashboard
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }

    // method untuk menampilkan semua halaman peminjaman barang mahasiswa
    public function mahasiswaPeminjamanBarang()
    {
        // mengambil semua data barang dan nama tipe barang dan nama ruangan
        $dataTablePengajuanPeminjaman = DataBarang::join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->join('rooms', 'items.id_room', '=', 'rooms.id_room')
            ->select('items.*', 'tipe_item.nama_tipe_item', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->latest()
            ->get();


        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentPeminjamanBarang'; // variable untuk menampilkan content peminjaman barang
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataTablePengajuanPeminjaman'));
    }

    // method untuk menampilkan semua halaman peminjaman ruangan mahasiswa
    public function mahasiswaPeminjamanRuang()
    {

        // mengambil semua data barang dan nama tipe barang dan nama ruangan
        $dataTablePengajuanPeminjaman = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->latest()
            ->get();


        // dd($dataTablePengajuanPeminjaman);
        // mengambil nama peminjam yg sedang login
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentPeminjamanRuang'; // variable untuk menampilkan content peminjaman ruang
        // return ke halaman pengajuan peminjaman user dengan menyisipkan data yg dibutuhkan
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataTablePengajuanPeminjaman'));
    }

    // method untuk menampilkan semua halaman peminjaman barang mahasiswa
    public function mahasiswaListPeminjaman()
    {
        // mengambil session cart ruangan
        $cart_ruangan = session()->get('cart_ruangan');
        // mengambil session cart yg berisi list barang yg diajukan peminjaman
        $cart_session = session()->get('cart', []);

        // mengubah session cart_ruangan menjadi objek collection
        $listRuanganDiajukan = new Collection($cart_ruangan);
        // mengubah session cart barang menjadi objek collection
        $listBarangDiajukan = new Collection($cart_session);

        $jmlhRuang = $listRuanganDiajukan->count();
        $jmlhBrng = $listBarangDiajukan->sum('qty_pinjam');

        // dd($listRuanganDiajukan);

        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $no_identitas = Auth::guard('peminjam')->user()->no_identitas;
        $halaman = 'contentListPeminjaman'; // variable untuk menampilkan content list peminjaman
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'no_identitas', 'listBarangDiajukan', 'listRuanganDiajukan', 'jmlhBrng', 'jmlhRuang'));
    }

    // method untuk menampilkan semua halaman riwayat peminjaman
    public function mahasiswaRiwayat()
    {
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentRiwayat'; // variable untuk menampilkan content riwayat
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user'));
    }
}
