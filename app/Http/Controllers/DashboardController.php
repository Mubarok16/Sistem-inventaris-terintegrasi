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
use App\Services\Admin\PengelolaanAgendaService;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\Admin\PengelolaanPeminjamanService;
use App\Services\Admin\PengelolaanUserService;
use App\Services\mahasiswa\DetailAgendaService;
use App\Services\mahasiswa\RiwayatPeminjamanService;
use Illuminate\Support\Facades\Session;

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

        // ambil inputan bulan
        if (session()->get('bulan-input') === null) {
            session()->put('bulan-input', now()->format('Y-m'));
        }
        $bulanInput = session()->get('bulan-input');
        // membuat variable unutk batasan perbulan  
        $bulan = Carbon::parse($bulanInput);

        $startDate = Carbon::parse($bulanInput)->startOfMonth()->toDateString();
        $endDate = Carbon::parse($bulanInput)->endOfMonth()->toDateString();

        // data untuk menampilkan jumlah peminjaman barang dan ruangan di dashboard admin
        $totalPeminjamanBarang = DB::table('usage_items')
            ->select(
                DB::raw('DATE(tgl_pinjam_usage_item) as tanggal'),
                DB::raw('count(*) as total')
            )
            ->where('status_usage_item', 'selesai')
            // ->where('kode_agenda', null)
            // ->whereBetween('tgl_pinjam_usage_item', [$startDate, $endDate])
            ->whereMonth('tgl_pinjam_usage_item', $bulan->month) // Mengambil angka bulan (misal: 5)
            ->whereYear('tgl_pinjam_usage_item', $bulan->year)
            ->groupBy(DB::raw('DATE(tgl_pinjam_usage_item)')) // Harus sama dengan di select
            ->orderBy(DB::raw('DATE(tgl_pinjam_usage_item)'), 'asc')
            ->get()
            ->pluck('total', 'tanggal');

        // data untuk menampilkan jumlah peminjaman barang dan ruangan di dashboard admin
        $totalPeminjamanRuangan = DB::table('usage_rooms')
            ->select(
                DB::raw('DATE(tgl_pinjam_usage_room) as tanggal'),
                DB::raw('count(*) as total')
            )
            // ->where('kode_agenda', null)
            ->where('status_usage_room', 'selesai')
            // ->whereBetween('tgl_pinjam_usage_room', [$startDate, $endDate])
            ->whereMonth('tgl_pinjam_usage_room', $bulan->month) // Mengambil angka bulan (misal: 5)
            ->whereYear('tgl_pinjam_usage_room', $bulan->year)
            ->groupBy(DB::raw('DATE(tgl_pinjam_usage_room)')) // Harus sama dengan di select
            ->orderBy(DB::raw('DATE(tgl_pinjam_usage_room)'), 'asc')
            ->get()
            ->pluck('total', 'tanggal');

        // total ruangan
        $totalRuangan = DB::table('rooms')
            ->count();

        // total barang
        $totalBarang = DB::table('items')
            ->select('qty_item')
            ->sum('qty_item');

        // agenda hari ini
        $AgendaToday = DB::table('usage_rooms')
            ->select(
                'tgl_pinjam_usage_room'
            )
            ->whereDate('tgl_pinjam_usage_room', now()->format('Y-m-d'))
            ->count();

        // peminjaman aktif
        $totalPeminjamanAktif = DB::table('peminjaman')
            ->where('status_peminjaman', 'selesai')
            ->whereMonth('tgl_pinjam', $bulan->month) // Mengambil angka bulan (misal: 5)
            ->whereYear('tgl_pinjam', $bulan->year)
            // ->get()
            ->count();

        // dd($totalPeminjamanAktif);

        // agenda yang sedang berlangsung
        $Agendaberlangsung = DB::table('usage_rooms')
            ->leftJoin('agenda_fakultas', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
            ->leftJoin('peminjaman', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->select(
                'rooms.nama_room',
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'agenda_fakultas.nama_agenda',
                'peminjaman.ket_peminjaman'
            )
            ->whereDate('usage_rooms.tgl_pinjam_usage_room', now()->format('Y-m-d'))
            ->where('usage_rooms.status_usage_room', 'digunakan')
            ->orderBy('usage_rooms.created_at', 'desc')
            ->limit(3)
            ->get();

        // Buat range 7 hari ke belakang menggunakan Carbon Period
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        $finalData = [];
        $finalDataRuangan = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');

            $finalData[] = [
                'tanggal' => $date->format('d - M'),
                // Jika di hasil query ada tanggalnya, pakai totalnya. Jika tidak ada, isi 0.
                'total' => $totalPeminjamanBarang->get($formattedDate, 0)
            ];

            $finalDataRuangan[] = [
                'tanggal' => $formattedDate,
                // Jika di hasil query ada tanggalnya, pakai totalnya. Jika tidak ada, isi 0.
                'total' => $totalPeminjamanRuangan->get($formattedDate, 0)
            ];
        }

        // dd($finalData, $finalDataRuangan);

        // memisahkan untuk keperluan Chart
        $labels = collect($finalData)->pluck('tanggal');
        $countsBarang = collect($finalData)->pluck('total')->sum();
        $countsRuangan = collect($finalDataRuangan)->pluck('total')->sum();

        // dd($countsBarang, $countsRuangan);

        // Pengajuan Peminjaman
        $pengajuanPeminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->select(
                'peminjaman.kode_peminjaman',
                'peminjaman.ket_peminjaman',
                'peminjaman.tgl_pinjam',
                'peminjaman.tgl_kembali',
                'peminjaman.status_peminjaman',
                'peminjam.nama_peminjam'
            ) // Pilih kolom yang diperlukan
            ->where('peminjaman.status_peminjaman', 'diajukan')
            ->orderBy('peminjaman.created_at', 'asc')
            ->get();

        // dd($bulanInput);

        // $user = Auth::user()->id_user;
        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentDashbord';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'labels', 'countsBarang', 'countsRuangan', 'totalPeminjamanAktif', 'totalBarang', 'totalRuangan', 'AgendaToday', 'Agendaberlangsung', 'pengajuanPeminjaman', 'bulanInput'));
    }

    // page agenda yang berlangsung di dashboard admin
    public function agendaBerlangsung()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        // agenda yang sedang berlangsung
        $Agendaberlangsung = DB::table('usage_rooms')
            ->leftJoin('agenda_fakultas', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
            ->leftJoin('peminjaman', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->select(
                'rooms.nama_room',
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'agenda_fakultas.nama_agenda',
                'peminjaman.ket_peminjaman'
            )
            ->whereDate('usage_rooms.tgl_pinjam_usage_room', now()->format('Y-m-d'))
            ->where('usage_rooms.status_usage_room', 'terjadwal')
            ->get();

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentAgendaBerlangsung';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'Agendaberlangsung'));
    }

    public function adminPengelolaanUser()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $PengelolaanUserService = new PengelolaanUserService;

        if (Session::get('filter-role') === null) {
            Session::put('filter-role', 'all');
        }

        if (Session::get('filter-status') === null) {
            Session::put('filter-status', 'active');
        }

        $role = Session::get('filter-role');
        $status = Session::get('filter-status');

        $filter = $PengelolaanUserService->dataAllUsersByFilter($role, $status);
        // $filterStatus = $PengelolaanUserService->dataAllUsersByStatus($status);

        // $AkunPeminjams = $filter['AkunUsers']->where('hak_akses', 'mahasiswa');
        // dd($AkunPeminjams);
        $AkunUsers = $filter['AkunUsers']->paginate(5);

        // dd($AkunUsers->paginate(3));

        $JmlhAdmin = User::where('hak_akses', 'admin')->count();
        $jmlhPenggunaAll = User::where('status', 'active')->count();
        $jmlhMhs = User::where('hak_akses', 'mahasiswa')->count();
        $jmlhMhsTA = User::where('hak_akses', 'admin')->where('status', 'unactive')->count();

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentPengelolaanUser';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'AkunUsers', 'JmlhAdmin', 'jmlhPenggunaAll', 'jmlhMhs', 'jmlhMhsTA', 'role', 'status'));
    }

    public function adminPengajuanPeminjaman()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

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
        } else {
            $status_penggunaan = session()->get('status-peminjaman');
        }
        // mengambil data dari db berdasarkan status nya
        $PengelolaanPeminjamanService = new PengelolaanPeminjamanService;
        $dataPengajuanPeminjaman = $PengelolaanPeminjamanService->dataPenggunaanBarangByStatus($status_penggunaan);

        // mengambil data total Peminjaman yg sudah di terjadwal dan sedang digunakan
        $totalPeminjaman = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('selesai');

        // mengambil data total yg diajukan
        $totalDiajukan = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('diajukan');
        // mengambil data total yg dipinjam
        $totalDipinjam = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('dipinjam');
        // mengambil data total yg terlambat dikembalikan
        $totalTerlambat = $PengelolaanPeminjamanService->hitungTotalPenggunaanByStatus('terlambat');
        // dd($totalPeminjaman);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
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
            // ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->join('rooms', 'items.id_room', '=', 'rooms.id_room')
            ->select(
                'items.*',
                // 'tipe_item.nama_tipe_item', 
                'rooms.nama_room'
            ) // Pilih kolom yang diperlukan
            ->latest()
            ->paginate(3);
        // ->get();
        // mengambil data tipe barang
        $DataTipeBarang = TipeRuangan::get();
        // mengambil data user yang sedang login
        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
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
            ->paginate(3);
        // ->get();

        $barang = DB::table('items')
            // ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->select(
                'id_room',
                'merek_model',
                'nama_item',
                'qty_item'
            )
            ->get()
            ->groupBy('id_room');

        $DataRuangan->map(function ($room) use ($barang) {
            // Masukkan daftar barang ke dalam properti baru bernama 'items'
            // Jika tidak ada barang di room tersebut, berikan array kosong
            $room->items = $barang->get($room->id_room) ?? collect([]);
            // Simpan total jumlah asli barang
            $room->total_items_count = $room->items->count();

            // Ambil hanya 3 barang pertama untuk ditampilkan
            $room->items = $room->items->take(3);
            return $room;
        });

        $DataTipeRuangan = TipeRuangan::get();

        // dd($DataRuangan);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
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

        $dataAgendas = DB::table('agenda_fakultas')
            // ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->leftJoin('usage_items', 'usage_items.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
            ->leftJoin('usage_rooms', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
            ->selectRaw('DISTINCT ON (agenda_fakultas.kode_agenda) 
                agenda_fakultas.*,
                usage_items.tgl_pinjam_usage_item, 
                usage_items.tgl_kembali_usage_item, 
                usage_rooms.tgl_pinjam_usage_room, 
                usage_rooms.tgl_kembali_usage_room, 
                usage_rooms.jam_mulai_usage_room, 
                usage_rooms.jam_selesai_usage_room, 
                usage_items.jam_mulai_usage_item, 
                usage_items.jam_selesai_usage_item')
            // ->where('peminjaman.no_identitas', '=', $id)

            // ->when($status !== 'semua', function ($query) use ($status) {
            //     return $query->where('peminjaman.status_peminjaman', $status);
            // })
            // ->where('peminjaman.status_peminjaman', $status)
            ->orderBy('agenda_fakultas.kode_agenda') // Mengelompokkan berdasarkan kode unik
            ->orderBy('agenda_fakultas.created_at', 'asc')
            ->paginate(3);
        // ->get();

        // dd($dataAgendas);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'DataAgenda', 'dataAgendas'));
    }

    // detail agenda calender di admin
    public function adminDetailAgenda($id, $date)
    {
        // if (Auth::user()->hak_akses  !== "admin" || Auth::user()->hak_akses  !== "pimpinan" || Auth::user()->hak_akses  !== "kaprodi") {
        //     abort(403, 'Unauthorized');
        // }

        $detailAgendaService = new DetailAgendaService;
        $dataAgenda = $detailAgendaService->dataPenggunaanBarangDanRuang($id, $date);

        $headerAgenda = $dataAgenda['header'];
        $usage_room = $dataAgenda['usage_ruang'];
        $usage_item = $dataAgenda['usage_barang'];
        $tglPinjam = $dataAgenda['tgl_pinjam'];

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentDetailAgendaCalender';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'headerAgenda', 'usage_room', 'usage_item', 'tglPinjam', 'id', 'date'));
    }

    // detail agenda edit per tgl di admin
    public function editAdminDetailAgendaPerhari($id, $date)
    {
        // if (Auth::user()->hak_akses  !== "admin" || Auth::user()->hak_akses  !== "pimpinan" || Auth::user()->hak_akses  !== "kaprodi") {
        //     abort(403, 'Unauthorized');
        // }

        $id = urldecode($id);

        // dd('ibnu');

        $detailAgendaService = new DetailAgendaService;
        $dataAgenda = $detailAgendaService->dataPenggunaanBarangDanRuang($id, $date);

        $headerAgenda = $dataAgenda['header'];
        $usage_room = $dataAgenda['usage_ruang'];
        $usage_item = $dataAgenda['usage_barang'];
        $tglPinjam = $dataAgenda['tgl_pinjam'];

        // megambil data barang dan ruangan yang digunakan di agenda tersebut untuk di edit

        $dataAgendas = DB::table('agenda_fakultas')
            ->where('agenda_fakultas.kode_agenda', $id)
            ->select(
                'agenda_fakultas.kode_agenda',
                'agenda_fakultas.nama_agenda',
                'agenda_fakultas.tgl_mulai_agenda',
                'agenda_fakultas.tgl_selesai_agenda',
                'agenda_fakultas.loop_hari',
                'agenda_fakultas.tipe_agenda'
            )
            ->get();

        // mengambil semua data barang dan nama tipe barang dan nama ruangan
        $databarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->select(
                'usage_items.id_item',
                'usage_items.qty_usage_item',
                'items.nama_item',
                'items.img_item',
                'items.kondisi_item',
                'tipe_item.nama_tipe_item',
                'usage_items.jam_mulai_usage_item',
                'usage_items.jam_selesai_usage_item',
            )
            ->where('usage_items.kode_agenda', $id)
            ->where('usage_items.tgl_pinjam_usage_item', $date)
            // ->whereNotIn('status_usage_item', ['selesai', 'digunakan', 'ditolak'])
            ->get();
        // ->unique('usage_items.id_item');

        // dd($databarang);

        $dataruangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select(
                'usage_rooms.id_room',
                'rooms.nama_room',
                'rooms.gambar_room',
                'rooms.kondisi_room',
                'tipe_rooms.nama_tipe_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
            )
            ->where('usage_rooms.kode_agenda', $id)
            ->where('usage_rooms.tgl_pinjam_usage_room', $date)
            // ->whereNotIn('status_usage_room', ['selesai', 'digunakan', 'ditolak'])
            ->get();
        // ->unique('usage_rooms.id_room');

        // menggabungkan data barang dan ruangan menjadi array
        $databarangruangan = $databarang->merge($dataruangan)->toArray();

        // dd($databarangruangan);

        // // ambil jam mulai dan jam selesainya saja 
        // foreach ($databarangruangan as $item) {
        //     // Ambil jam mulai (cek item dulu, jika null ambil room)
        //     $jamMulai = $item->jam_mulai_usage_item ?? $item->jam_mulai_usage_room;

        //     // Ambil jam selesai
        //     $jamSelesai = $item->jam_selesai_usage_item ?? $item->jam_selesai_usage_room;
        // }

        // // menghilangkan jam_mulai dan jam_selesai dari array databarangruangan
        // foreach ($databarangruangan as $item) {
        //     unset($item->jam_mulai_usage_room);
        //     unset($item->jam_selesai_usage_room);
        // }

        // Menambah jam mulai dan jam selesai ke data agenda 
        $dataAgendas = $dataAgendas->toArray();

        // dd($databarang, $dataruangan);


        // $dataAgendas[0]->jam_mulai = $jamMulai;
        // $dataAgendas[0]->jam_selesai = $jamSelesai;

        // dd($dataAgendas);

        // if ($jamMulai === null) {
        //     $dataAgendas[0]->tipe_jam = 'full day';
        // } else {
        //     $dataAgendas[0]->tipe_jam = 'spesifik';
        // }

        // dd($dataAgendas);

        // ambil id di session
        $sessionKode = session('kode_agenda_edit_perhari');

        // jika belum ada session atau id di session tidak sama dengan id yang di edit, maka simpan data barang dan ruang serta data agenda ke session
        if (!session()->has('semua_data_edit_barang_ruang') || $sessionKode != $id) {

            // hapus session lama jika ada
            session()->forget(['semua_data_edit_barang_ruang', 'kode_agenda_edit_perhari']);

            // simpan array barang dan ruang ke session
            session(['semua_data_edit_barang_ruang_perhari' => $databarangruangan]);

            // simpan array agenda ke session
            // session(['data_agenda_edit' => $dataAgendas]);
        }

        // jika belum ada session atau id di session tidak sama dengan id yang di edit, maka simpan data agenda ke session
        // if (!session()->has('data_agenda_edit') || $sessionKode != $id) {
        //     // hapus session lama jika ada
        //     session()->forget('data_agenda_edit');

        //     // simpan array agenda ke session
        //     session(['data_agenda_edit' => $dataAgendas]);
        // }

        // simpan kode agenda ke session
        session(['kode_agenda_edit_perhari' => $id]);

        // ambil data dari session data brang dan ruang serta data agenda
        $semuaData = collect(session('semua_data_edit_barang_ruang_perhari'));
        // $dataAgenda = collect(session('data_agenda_edit'));


        // mengambil semua data barang dan ruangan
        $PengelolaanAgendaService = new PengelolaanAgendaService;
        $allBarangRuang = $PengelolaanAgendaService->getBarangDanRaung()->toArray();

        // dd($semuaData, $databarangruangan);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentDetailAgendaEditPerhari';
        return view(
            'Page_admin.dashboard-admin',
            compact(
                'halaman',
                'user',
                'headerAgenda',
                'usage_room',
                'usage_item',
                'tglPinjam',
                'id',
                'date',
                'semuaData',
                'allBarangRuang',
            )
        );
    }

    // page pengadaan barang
    public function adminPengadaanBarang()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $pengadaan = DB::table('pengadaan_barang')
            ->join('users', 'users.id_user', '=', 'pengadaan_barang.id_pemohon')
            ->leftJoin('detail_staff', 'detail_staff.id_user', '=', 'pengadaan_barang.id_pemohon')
            ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'pengadaan_barang.id_pemohon')
            ->select(
                'pengadaan_barang.*',
                // 'users.nama as nama_pemohon'
                DB::raw('COALESCE(detail_staff.nama, detail_dosen.nama) as nama_pemohon')
            )
            ->get();

        // dd($pengadaan);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentPengadaanBarang';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'pengadaan'));
    }

    public function AdminPerawatanBarang()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $perawatan = DB::table('perawatan_barang')
            ->join('users', 'users.id_user', '=', 'perawatan_barang.id_pemohon')
            ->leftJoin('detail_staff', 'detail_staff.id_user', '=', 'perawatan_barang.id_pemohon')
            ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'perawatan_barang.id_pemohon')
            ->leftJoin('items', 'items.id_item', '=', 'perawatan_barang.id_item')
            ->leftJoin('rooms', 'rooms.id_room', '=', 'perawatan_barang.id_room')
            ->select(
                'perawatan_barang.*',
                'items.nama_item',
                'items.merek_model',
                'rooms.nama_room',
                DB::raw('COALESCE(detail_staff.nama, detail_dosen.nama) as nama_pemohon')

            )
            ->get();

        // dd($perawatan);

        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentPerawatanBarang';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'perawatan'));
    }

    // calender admin
    public function calenderAdmin()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $halaman = 'contentAgendaBerlangsung';
        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
    }



    // --- PIMPINAN ---------------------------------------------------------------------------------------

    // page dashboard pimpinan
    public function pimpinan()
    {
        // cek jika user yg login bukan pimpinan akan di arahkan ke halaman unauthorize
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        if (session()->get('bulan-input') === null) {
            session()->put('bulan-input', now()->format('Y-m'));
        }

        $bulanInput = session()->get('bulan-input'); // Ambil bulan dari session atau gunakan bulan saat ini

        ///////////////////////////////////////////////// chart //////////////////////////////////////////////////////////////////
        // data untuk cart
        $startDate = Carbon::parse($bulanInput)->startOfMonth()->toDateString();
        $endDate = Carbon::parse($bulanInput)->endOfMonth()->toDateString();

        // data untuk menampilkan jumlah peminjaman barang dan ruangan di dashboard admin
        $totalPeminjamanBarang = DB::table('usage_items')
            ->select(
                DB::raw('DATE(tgl_pinjam_usage_item) as tanggal'),
                DB::raw('count(*) as total')
            )
            ->where('status_usage_item', 'selesai')
            // ->where('kode_agenda', null)
            ->whereBetween('tgl_pinjam_usage_item', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tgl_pinjam_usage_item)')) // Harus sama dengan di select
            ->orderBy(DB::raw('DATE(tgl_pinjam_usage_item)'), 'asc')
            ->get()
            ->pluck('total', 'tanggal');

        // data untuk menampilkan jumlah peminjaman barang dan ruangan di dashboard admin
        $totalPeminjamanRuangan = DB::table('usage_rooms')
            ->select(
                DB::raw('DATE(tgl_pinjam_usage_room) as tanggal'),
                DB::raw('count(*) as total')
            )
            // ->where('kode_agenda', null)
            ->where('status_usage_room', 'selesai')
            ->whereBetween('tgl_pinjam_usage_room', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tgl_pinjam_usage_room)')) // Harus sama dengan di select
            ->orderBy(DB::raw('DATE(tgl_pinjam_usage_room)'), 'asc')
            ->get()
            ->pluck('total', 'tanggal');

        // Buat range 1 bulanterakhir Carbon Period
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        $finalData = [];
        $finalDataRuangan = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');

            $finalData[] = [
                'tanggal' => $date->format('d'),
                // Jika di hasil query ada tanggalnya, pakai totalnya. Jika tidak ada, isi 0.
                'total' => $totalPeminjamanBarang->get($formattedDate, 0)
            ];

            $finalDataRuangan[] = [
                'tanggal' => $formattedDate,
                // Jika di hasil query ada tanggalnya, pakai totalnya. Jika tidak ada, isi 0.
                'total' => $totalPeminjamanRuangan->get($formattedDate, 0)
            ];
        }

        // memisahkan untuk keperluan Chart
        $labels = collect($finalData)->pluck('tanggal');
        $countsBarang = collect($finalData)->pluck('total')->sum();
        $countsRuangan = collect($finalDataRuangan)->pluck('total')->sum();

        // dd($countsBarang->sum(), $countsRuangan->sum());

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentDashbordPimpinan';
        return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user', 'bulanInput', 'labels', 'countsBarang', 'countsRuangan'));
    }
    // page kalender di pimpinan
    public function calenderPimpinan(Request $request)
    {
        if (Auth::user()->hak_akses  !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentCalenderPimpinan';
        return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user'));
    }



    // --- KAPRODI ---------------------------------------------------------------------------------------

    // method untuk agar kaprodi hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function Dashboardkaprodi()
    {
        if (Auth::user()->hak_akses !== "kaprodi") {
            abort(403, 'Unauthorized');
        }

        if (session()->get('bulan-input') === null) {
            session()->put('bulan-input', now()->format('Y-m'));
        }

        $bulanInput = session()->get('bulan-input'); // Ambil bulan dari session atau gunakan bulan saat ini

        ///////////////////////////////////////////////// chart //////////////////////////////////////////////////////////////////
        // data untuk cart
        $startDate = Carbon::parse($bulanInput)->startOfMonth()->toDateString();
        $endDate = Carbon::parse($bulanInput)->endOfMonth()->toDateString();

        // data untuk menampilkan jumlah peminjaman barang dan ruangan di dashboard admin
        $totalPeminjamanBarang = DB::table('usage_items')
            ->select(
                DB::raw('DATE(tgl_pinjam_usage_item) as tanggal'),
                DB::raw('count(*) as total')
            )
            ->where('status_usage_item', 'selesai')
            // ->where('kode_agenda', null)
            ->whereBetween('tgl_pinjam_usage_item', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tgl_pinjam_usage_item)')) // Harus sama dengan di select
            ->orderBy(DB::raw('DATE(tgl_pinjam_usage_item)'), 'asc')
            ->get()
            ->pluck('total', 'tanggal');

        // data untuk menampilkan jumlah peminjaman barang dan ruangan di dashboard admin
        $totalPeminjamanRuangan = DB::table('usage_rooms')
            ->select(
                DB::raw('DATE(tgl_pinjam_usage_room) as tanggal'),
                DB::raw('count(*) as total')
            )
            // ->where('kode_agenda', null)
            ->where('status_usage_room', 'selesai')
            ->whereBetween('tgl_pinjam_usage_room', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(tgl_pinjam_usage_room)')) // Harus sama dengan di select
            ->orderBy(DB::raw('DATE(tgl_pinjam_usage_room)'), 'asc')
            ->get()
            ->pluck('total', 'tanggal');

        // Buat range 1 bulanterakhir Carbon Period
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);

        $finalData = [];
        $finalDataRuangan = [];
        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');

            $finalData[] = [
                'tanggal' => $date->format('d'),
                // Jika di hasil query ada tanggalnya, pakai totalnya. Jika tidak ada, isi 0.
                'total' => $totalPeminjamanBarang->get($formattedDate, 0)
            ];

            $finalDataRuangan[] = [
                'tanggal' => $formattedDate,
                // Jika di hasil query ada tanggalnya, pakai totalnya. Jika tidak ada, isi 0.
                'total' => $totalPeminjamanRuangan->get($formattedDate, 0)
            ];
        }

        // memisahkan untuk keperluan Chart
        $labels = collect($finalData)->pluck('tanggal');
        $countsBarang = collect($finalData)->pluck('total')->sum();
        $countsRuangan = collect($finalDataRuangan)->pluck('total')->sum();


        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentDashborKaprodi';
        return view('Page_kaprodi.dashboardKaprodi', compact('halaman', 'user', 'bulanInput', 'labels', 'countsBarang', 'countsRuangan'));
    }

    // page pengadaan barang
    public function KprodiPengadaanBarang()
    {
        if (Auth::user()->hak_akses  !== "kaprodi") {
            abort(403, 'Unauthorized');
        }

        $pengadaan = DB::table('pengadaan_barang')
            ->where('id_pemohon', '=', Auth::user()->id_user)
            ->get();

        // dd($pengadaan);

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentPengadaanBarang';
        return view('Page_kaprodi.dashboardKaprodi', compact('halaman', 'user', 'pengadaan'));
    }

    // page perawatan barang
    public function PagePengajuanPerawatanBarangKaprodi(Request $request)
    {
        if (Auth::user()->hak_akses  !== "kaprodi") {
            abort(403, 'Unauthorized');
        }

        $perawatan = DB::table('perawatan_barang')
            ->join('users', 'users.id_user', '=', 'perawatan_barang.id_pemohon')
            ->join('detail_staff', 'users.id_user', '=', 'users.id_user')
            ->leftJoin('items', 'items.id_item', '=', 'perawatan_barang.id_item')
            ->leftJoin('rooms', 'rooms.id_room', '=', 'perawatan_barang.id_room')
            ->select(
                'perawatan_barang.*',
                'items.nama_item',
                'items.merek_model',
                'rooms.nama_room',
                'detail_staff.nama as nama_pemohon'
            )
            ->where('perawatan_barang.id_pemohon', '=', Auth::user()->id_user)
            ->get();

        // dd($perawatan);

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentPerawatanBarang';
        return view('Page_kaprodi.dashboardKaprodi', compact(
            'halaman',
            'user',
            'perawatan',
        ));
    }

    // page form pengajuan perawatan
    public function PageFormPengajuanPerawatanBarangKaprodi(Request $request)
    {
        if (Auth::user()->hak_akses  !== "kaprodi") {
            abort(403, 'Unauthorized');
        }

        $dataBarang = DataBarang::join('rooms', 'items.id_room', 'rooms.id_room')
            ->select('items.*', 'rooms.nama_room')
            ->latest() // Pilih kolom yang diperlukan
            ->get();
        // dd($dataBarang);

        $dataRoom = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room')
            ->latest() // Pilih kolom yang diperlukan
            ->get();

        // mengambil data barang dan rungan yg di input user di session
        $semuaData = collect(session('data_perawatan_barang_ruang'));
        // mengambil data tambh agenda yg di input admin
        $dataAgenda = collect(session('data_header_perawatan_temp'));

        // dd($semuaData);

        // mengambil semua data barang dan ruangan
        $PengelolaanAgendaService = new PengelolaanAgendaService;
        $allBarangRuang = $PengelolaanAgendaService->getBarangDanRaung()->toArray();


        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        // dd($user);

        $halaman = 'contentFormPerawatanBarang';
        return view('Page_kaprodi.dashboardKaprodi', compact(
            'halaman',
            'user',
            'dataBarang',
            'dataRoom',
            'semuaData',
            'allBarangRuang',
            'dataAgenda'
        ));
    }

    // page kalender di kaprodi
    public function calenderKaprodi(Request $request)
    {
        if (Auth::user()->hak_akses  !== "kaprodi") {
            abort(403, 'Unauthorized');
        }

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentCalenderKaprodi';
        return view('Page_kaprodi.dashboardKaprodi', compact('halaman', 'user'));
    }



    // --- MAHASISWA ---------------------------------------------------------------------------------------

    // method untuk agar mahasiswa hanya bisa mengakses halaman sesuai dengan hak aksesnya

    // memanggil halaman dashboard peminjam(mahasiswa)
    public function mahasiswa()
    {

        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();

        $no_identitas = $peminjam->no_identitas;

        // dd($no_identitas);

        $dataPeminjamanByMhs = DB::table('peminjaman')
            ->where('no_identitas', '=', $no_identitas)
            ->whereIn('status_peminjaman', ['terjadwal', 'digunakan'])
            ->count();

        $dataPeminjamanLewatByMhs = DB::table('peminjaman')
            ->where('no_identitas', '=', $no_identitas)
            ->whereIn('status_peminjaman', ['terlambat'])
            ->count();

        $dataPeminjamanDiajukanByMhs = DB::table('peminjaman')
            ->where('no_identitas', '=', $no_identitas)
            ->whereIn('status_peminjaman', ['diajukan'])
            ->count();

        // dd($dataPeminjamanDiajukanByMhs);

        $user = $peminjam->nama_peminjam;
        $halaman = 'contentDashbord'; // variable untuk menampilkan content dashboard
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataPeminjamanByMhs', 'dataPeminjamanLewatByMhs', 'dataPeminjamanDiajukanByMhs'));
    }

    // memanggil halaman detail agenda dari calender di user
    public function mahasiswaAgenda($id, $date)
    {
        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();


        $detailAgendaService = new DetailAgendaService;
        $dataAgenda = $detailAgendaService->dataPenggunaanBarangDanRuang($id, $date);

        $headerAgenda = $dataAgenda['header'];
        $usage_room = $dataAgenda['usage_ruang'];
        $usage_item = $dataAgenda['usage_barang'];
        $tglPinjam = $dataAgenda['tgl_pinjam'];

        $user = $peminjam->nama_peminjam;
        $halaman = 'contentDetailAgenda'; // variable untuk menampilkan content dashboard
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'headerAgenda', 'usage_room', 'usage_item', 'tglPinjam'));
    }

    // method untuk menampilkan semua halaman peminjaman barang mahasiswa
    public function mahasiswaPeminjamanBarang()
    {
        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();

        $dataTablePengajuanPeminjaman = DataBarang::join('rooms', 'items.id_room', '=', 'rooms.id_room')
            ->select('items.*', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->where('visibility_item', '1')
            ->latest()
            ->get();


        $user = $peminjam->nama_peminjam;
        $halaman = 'contentPeminjamanBarang'; // variable untuk menampilkan content peminjaman barang
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataTablePengajuanPeminjaman'));
    }

    // method untuk menampilkan semua halaman peminjaman ruangan mahasiswa
    public function mahasiswaPeminjamanRuang()
    {
        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();

        // mengambil semua data barang dan nama tipe barang dan nama ruangan
        $dataTablePengajuanPeminjaman = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->where('visibility_room', '1')
            ->latest()
            ->get();


        // dd($dataTablePengajuanPeminjaman);
        // mengambil nama peminjam yg sedang login
        $user = $peminjam->nama_peminjam;
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

        // dd($listRuanganDiajukan, $listBarangDiajukan, $jmlhRuang, $jmlhBrng);

        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();

        $user = $peminjam->nama_peminjam;
        $no_identitas = $peminjam->no_identitas;

        $halaman = 'contentListPeminjaman'; // variable untuk menampilkan content list peminjaman
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'no_identitas', 'listBarangDiajukan', 'listRuanganDiajukan', 'jmlhBrng', 'jmlhRuang'));
    }

    // method untuk menampilkan semua halaman riwayat peminjaman
    public function mahasiswaRiwayat()
    {
        $RiwayatService = new RiwayatPeminjamanService;

        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();

        $idUser = $peminjam->no_identitas;

        // filter riwayat berdasarkan status tertentu
        $status_penggunaan = null;

        if (session()->get('status-riwayat') === null) {
            $status_penggunaan = 'semua';
        } else {
            $status_penggunaan = session()->get('status-riwayat');
        }

        $dataPeminjamanByPeminjam = $RiwayatService->dataPeminjamanByStatus($status_penggunaan, $idUser);


        // dd($dataPeminjamanByPeminjam);

        $id_user = Auth::user()->id_user;

        $peminjam = DB::table('peminjam')
            ->where('id_user', '=', $id_user)
            ->first();

        $user = $peminjam->nama_peminjam;
        $halaman = 'contentRiwayat'; // variable untuk menampilkan content riwayat
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataPeminjamanByPeminjam', 'status_penggunaan'));
    }



    /// alll users
    public function profile()
    {
        // $peminjam = Auth::guard('peminjam')->user()->nama_peminjam;
        // $users = Auth::user()->nama;

        # jika users (admin/pimpinan/kaprodi)
        if (Auth::user()->hak_akses == 'admin') {
            // dd('admin');

            $id = Auth::user()->id_user;

            // mengamil data peminjam by id
            $dataPeminjam = null;

            // mengambil data user
            $dataUser = DB::table('users')
                ->join('detail_staff', 'users.id_user', '=', 'detail_staff.id_user')
                ->where('users.id_user', '=', $id)
                ->first();

            $JmlhAdmin = User::where('hak_akses', 'admin')->count();


            $halaman = 'contentProfile';
            $user = $dataUser->nama;
            return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataPeminjam', 'dataUser', 'JmlhAdmin'));
        } elseif (Auth::user()->hak_akses == 'pimpinan') {
            $id = Auth::user()->id_user;

            // mengamil data peminjam by id
            $dataPeminjam = null;

            // mengambil data user
            $dataUser = DB::table('users')
                ->join('detail_dosen', 'users.id_user', '=', 'detail_dosen.id_user')
                ->where('users.id_user', '=', $id)
                ->first();

            $JmlhAdmin = User::where('hak_akses', 'admin')->count();


            $halaman = 'contentProfile';
            $user = $dataUser->nama;
            return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user', 'dataPeminjam', 'dataUser', 'JmlhAdmin'));
        } elseif (Auth::user()->hak_akses == 'kaprodi') {
            $id = Auth::user()->id_user;

            // mengamil data peminjam by id
            $dataPeminjam = null;
            // mengambil data user
            $dataUser = DB::table('users')
                ->join('detail_dosen', 'users.id_user', '=', 'detail_dosen.id_user')
                ->where('users.id_user', '=', $id)
                ->first();

            $JmlhAdmin = User::where('hak_akses', 'admin')->count();


            $halaman = 'contentProfile';
            $user = $dataUser->nama;
            return view('Page_kaprodi.dashboardKaprodi', compact('halaman', 'user', 'dataPeminjam', 'dataUser', 'JmlhAdmin'));
        } else {
            abort(403, 'Unauthorized');
        }
    }

    // peminjam
    public function profilePeminjam()
    {
        $id_user = Auth::user()->id_user;


        if (Auth::user()->hak_akses == 'mahasiswa') {
            // mengamil data peminjam by id
            $dataPeminjam = DB::table('users')
                ->join('peminjam', 'users.id_user', '=', 'peminjam.id_user')
                ->where('users.id_user', '=', $id_user)
                ->first();
            $dataUser = null;
            $user = $dataPeminjam->nama_peminjam;
        } else {

            if (Auth::user()->hak_akses == 'admin') {
                # code...
                // mengambil data user
                $dataUser = DB::table('users')
                    ->join('detail_staff', 'users.id_user', '=', 'detail_staff.id_user')
                    ->where('users.id_user', '=', $id_user)
                    ->first();

                $dataPeminjam = null;

                $user = $dataUser->nama;
            } else {
                $dataUser = DB::table('users')
                    ->join('detail_dosen', 'users.id_user', '=', 'detail_dosen.id_user')
                    ->where('users.id_user', '=', $id_user)
                    ->first();

                $dataPeminjam = null;

                $user = $dataUser->nama;
            }
        }



        $JmlhAdmin = User::where('hak_akses', 'admin')->count();


        $halaman = 'contentProfile';
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataPeminjam', 'dataUser', 'JmlhAdmin'));
    }
}
