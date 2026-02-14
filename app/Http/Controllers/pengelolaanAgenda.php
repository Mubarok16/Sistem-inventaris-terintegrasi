<?php

namespace App\Http\Controllers;

use App\Imports\AgendaImport;
use App\Models\agendaFakultas;
use App\Models\DataBarang;
use App\Models\DataRuangan;
use App\Models\UsageItems;
use App\Models\UsageRooms;
use App\Services\Admin\PengelolaanAgendaService;
use App\Services\Admin\PengelolaanPeminjamanService;
use App\Services\mahasiswa\RiwayatPeminjamanService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Wajib di-import

use function Symfony\Component\Clock\now;

class pengelolaanAgenda extends Controller
{
    // page halaman import agenda
    public function pageImportAgenda()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user()->nama;
        $halaman = 'contentImportAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
    }

    // fungsi tambah agenda import
    public function addAgendaImport(Request $request)
    {
        // $user = Auth::user()->id_user;

        $tgl_mulai   = $request->input('tgl_mulai');
        $tgl_selesai = $request->input('tgl_selesai');

        try {
            $request->validate([
                'fileAgenda' => 'required|mimes:csv,xlsx,xls'
            ]);


            $import = new AgendaImport($tgl_mulai, $tgl_selesai);
            Excel::import($import, $request->file('fileAgenda'));

            // data hasil dari file import
            $hasil = $import->dataHasilOlahan;

            // dd($hasil);

            // mengambil id_room dan nama room 
            $mapRuangan = DataRuangan::pluck('id_room', 'nama_room')->toArray();

            // menggabungkan array dari file import ke array baru yg mengubah nama ruangan menjadi id_room
            $agendaFakultas = collect($hasil)->map(function ($item) use ($mapRuangan) {

                // memecah jam jadi jam mulai dan jam selesai
                $jam_raw = $item['jam']; // "9:00 - 12:00"
                $parts = explode(' - ', $jam_raw); // Memecah string berdasarkan " - "

                $jam_mulai   = $parts[0] ?? null; // "9:00"
                $jam_selesai = $parts[1] ?? null; // "12:00"

                if ($item['tanggal'] === null) {
                    $tgl_mulai_agenda = $item['tgl_mulai'];
                    $tgl_selesai_agenda = $item['tgl_selesai'];
                } else {
                    $tgl_mulai_agenda = $item['tanggal'];
                    $tgl_selesai_agenda = $item['tanggal'];
                }

                // return kembali ke sesuai struktur db agenda fakultas
                return [
                    'kode_agenda' => $item['kode_agenda'],
                    'id_user' => Auth::user()->id_user,
                    'nama_agenda' => $item['nama_agenda'],
                    'tipe_agenda'        => $item['hari'] === null ? 'pts/pas' : 'kegiatan belajar mengejar',
                    'tgl_mulai_agenda'   => $tgl_mulai_agenda,
                    'tgl_selesai_agenda' => $tgl_selesai_agenda,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                    'loop_hari' => $item['hari'] === null ? 'setiap hari' : $item['hari']
                ];
            })->toArray();

            // menggabungkan array dari file import ke array baru yg mengubah nama ruangan menjadi id_room
            $usage_room = collect($hasil)->flatMap(function ($item) use ($mapRuangan) {

                // memecah jam jadi jam mulai dan jam selesai
                $jam_raw = $item['jam']; // "9:00 - 12:00"
                $parts = explode(' - ', $jam_raw); // Memecah string berdasarkan " - "

                $jam_mulai   = $parts[0] ?? null; // "9:00"
                $jam_selesai = $parts[1] ?? null; // "12:00"

                if ($item['tanggal'] === null) {
                    $tgl_mulai_agenda = $item['tgl_mulai'];
                    $tgl_selesai_agenda = $item['tgl_selesai'];
                } else {
                    $tgl_mulai_agenda = $item['tanggal'];
                    $tgl_selesai_agenda = $item['tanggal'];
                }

                $dataRoom = [];
                // // perode untuk usage room ketika inport untuk import harian
                // if ($item['hari'] === null) {
                //     $period = CarbonPeriod::create($tgl_mulai_agenda, $tgl_selesai_agenda);
                //     foreach ($period as $date) {       // Loop untuk Tanggal per Hari
                //         $dataRoom[] = [
                //             'kode_peminjaman' => NULL,
                //             'kode_agenda' => $item['kode_agenda'],
                //             'id_room' => $mapRuangan[$item['ruangan']] ?? null,
                //             'tgl_pinjam_usage_room' => $date->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                //             'tgl_kembali_usage_room' => $date->setTime(23, 0, 0)->format('Y-m-d H:i:s'),
                //             'status_usage_room' => 'terjadwal',
                //             'created_at' => now(),
                //             'updated_at' => now(),
                //             'jam_mulai_usage_room' => $jam_mulai,
                //             'jam_selesai_usage_room' => $jam_selesai,
                //         ];
                //     }
                // }else{
                //     // perode untuk usage room ketika inport untuk import mingguan
                //     $period = CarbonPeriod::create($tgl_mulai_agenda, '1 week', $tgl_selesai_agenda);
                //     foreach ($period as $date) {       // Loop untuk Tanggal per Minggu
                //         $dataRoom[] = [
                //             'kode_peminjaman' => NULL,
                //             'kode_agenda' => $item['kode_agenda'],
                //             'id_room' => $mapRuangan[$item['ruangan']] ?? null,
                //             'tgl_pinjam_usage_room' => $date->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                //             'tgl_kembali_usage_room' => $date->setTime(23, 0, 0)->format('Y-m-d H:i:s'),
                //             'status_usage_room' => 'terjadwal',
                //             'created_at' => now(),
                //             'updated_at' => now(),
                //             'jam_mulai_usage_room' => $jam_mulai,
                //             'jam_selesai_usage_room' => $jam_selesai,
                //         ];
                //     }
                // }

                // Ambil tanggal mulai asli
                $startDate = Carbon::parse($tgl_mulai_agenda);

                // Jika ada input 'hari' (misal: 'Senin', 'Selasa')
                if ($item['hari'] !== null) {
                    // Terjemahkan hari ke Bahasa Inggris jika input Anda Bahasa Indonesia
                    // Atau langsung gunakan jika inputnya 'Monday', 'Tuesday', dsb.
                    $mapHari = [
                        'senin'  => 'Monday',
                        'selasa' => 'Tuesday',
                        'rabu'   => 'Wednesday',
                        'kamis'  => 'Thursday',
                        'jumat'  => 'Friday',
                        'sabtu'  => 'Saturday',
                        'minggu' => 'Sunday',
                    ];

                    $hariInggris = $mapHari[$item['hari']] ?? $item['hari'];

                    // Cek apakah hari ini sudah sesuai dengan hari yang diinginkan?
                    // Jika belum, cari tanggal "hari" tersebut yang akan datang
                    if ($startDate->format('l') !== $hariInggris) {
                        $startDate->next($hariInggris);
                    }
                }

                // Buat periode berdasarkan tanggal yang sudah disesuaikan
                if ($item['hari'] === null) {
                    $period = CarbonPeriod::create($startDate, $tgl_selesai_agenda);
                } else {
                    // Sekarang $startDate sudah bukan lagi tgl 25 (Minggu), 
                    // tapi sudah pindah ke hari yang sesuai (misal Senin tgl 26)
                    $period = CarbonPeriod::create($startDate, '1 week', $tgl_selesai_agenda);
                }

                foreach ($period as $date) {
                    $currentDate = $date->toDateString();
                    $dataRoom[] = [
                        'kode_peminjaman' => NULL,
                        'kode_agenda' => $item['kode_agenda'],
                        'id_room' => $mapRuangan[$item['ruangan']] ?? null,
                        'tgl_pinjam_usage_room' => $currentDate . ' 00:00:00',
                        'tgl_kembali_usage_room' => $currentDate . ' 23:00:00',
                        'status_usage_room' => 'terjadwal',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'jam_mulai_usage_room' => $jam_mulai,
                        'jam_selesai_usage_room' => $jam_selesai,
                    ];
                }

                return $dataRoom;
            })->toArray();

            // dd($agendaFakultas, $usage_room);

            if ($agendaFakultas != null) {
                DB::table('agenda_fakultas')->insert($agendaFakultas);
            }

            if ($usage_room != null) {
                DB::table('usage_rooms')->insert($usage_room);
            }

            return redirect()->route('dashboard-admin-agenda')->with('success', 'Data Agenda Berhasil Diimport!');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    //fungsi menyimpan usage room dan usage item 1x/minggu
    public function simpanWeek(Request $request, $tgl_mulai, $tgl_selesai, $jam_mulai, $jam_selesai, $kode_agenda)
    {
        // mengambil data input agenda barang dan ruangan
        $dataAgendaBarangTemp = $request->session()->get('data_input_barang', []);
        $dataAgendaRuanganTemp = $request->session()->get('data_input_ruangan', []);

        // parsing tgl mulai dan tgl selesai sesuai dengan carbon(bawaan laravel) 
        $startDate = Carbon::parse($tgl_mulai);
        $endDate = Carbon::parse($tgl_selesai);

        $targetDayOfWeek = $startDate->dayOfWeek; // Mengambil angka hari dari $startDate 1/2/dan strsnya untuk senin/selasa/dan strsnya

        $currentDate = $startDate->copy();

        // Loop dari Tanggal Mulai hingga Tanggal Akhir
        while ($currentDate->lessThanOrEqualTo($endDate)) {

            // Bandingkan angka hari dalam seminggu
            if ($currentDate->dayOfWeek === $targetDayOfWeek) {

                // loop untuk menyimpan lebih dari 1 brang yg dinputkan dari array input barang di session
                foreach ($dataAgendaBarangTemp as $barang) {
                    //simpan barang ke db usage_barang
                    UsageItems::create([
                        'kode_peminjaman' => NULL,
                        'kode_agenda' => $kode_agenda,
                        'id_item' => $barang['id_item'],
                        'qty_usage_item' => $barang['qty_usage'],
                        'tgl_pinjam_usage_item' => $currentDate->copy()->setTimeFromTimeString($jam_mulai)->toDateTimeString(),
                        'tgl_kembali_usage_item' => $currentDate->copy()->setTimeFromTimeString($jam_selesai)->toDateTimeString(),
                        'status_usage_item' => 'belum digunakan',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // loop untuk menyimpan lebih dari 1 ruangan yg dinputkan dari array input barang di session
                foreach ($dataAgendaRuanganTemp as $ruangan) {
                    //simpan barang ke db usage_barang
                    UsageRooms::create([
                        'kode_peminjaman' => NULL,
                        'kode_agenda' => $kode_agenda,
                        'id_room' => $ruangan['id_room'],
                        'tgl_pinjam_usage_room' => $currentDate->copy()->setTimeFromTimeString($jam_mulai)->toDateTimeString(),
                        'tgl_kembali_usage_room' => $currentDate->copy()->setTimeFromTimeString($jam_selesai)->toDateTimeString(),
                        'status_usage_room' => 'belum digunakan',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            // Pindah ke hari berikutnya
            $currentDate->addDay();
        }

        // hapus data input temp dari session
        $request->session()->forget('data_input_agenda');
        $request->session()->forget('data_input_barang');
        $request->session()->forget('data_input_ruangan');
    }

    //fungsi menyimpan usage room dan usage item 1x/hari belum jadi
    public function simpanDay(Request $request, $tgl_mulai, $tgl_selesai, $jam_mulai, $jam_selesai, $kode_agenda) {}

    //return halaman detail agenda
    public function DetailAgenda($id)
    {
        // menentukan user yang login itu apakah role admin atau bukan jika bukan akan di arahkan eror 403 
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $dataDetailPengajuanPeminjaman = DB::table('agenda_fakultas')
            ->where('agenda_fakultas.kode_agenda', $id)
            ->get();

        $dataDetailPengajuanPeminjamanBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select('usage_items.*', 'items.nama_item', 'items.id_item', 'items.kondisi_item', 'items.img_item') // Pilih kolom yang diperlukan
            ->where('usage_items.kode_agenda', $id)
            ->get();

        $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_agenda', $id)
            ->get();

        // mengambil tgl pinjam dan tgl kembali dari usage_items dan usage_rooms
        $tglPinjamItem = DB::table('usage_items')
            ->select('tgl_pinjam_usage_item', 'tgl_kembali_usage_item')
            ->where('kode_agenda', $id)
            ->get();

        $tglPinjamRoom = DB::table('usage_rooms')
            ->select('tgl_pinjam_usage_room', 'tgl_kembali_usage_room')
            ->where('kode_agenda', $id)
            ->get();

        $tglPinjam = null;
        $tglKembali = null;

        if (!$tglPinjamItem->isEmpty()) {
            foreach ($tglPinjamItem as $value) {
                $tglPinjam = $value->tgl_pinjam_usage_item;
                $tglKembali = $value->tgl_kembali_usage_item;
            }
        } else {
            foreach ($tglPinjamRoom as $value) {
                $tglPinjam = $value->tgl_pinjam_usage_room;
                $tglKembali = $value->tgl_kembali_usage_room;
            }
        }

        // cek jadwal agenda
        $PengelolaanPeminjamanService = new PengelolaanPeminjamanService;
        $dataBentrokJadwal = $PengelolaanPeminjamanService->cekPeminjamanAgenda($id, $tglPinjam, $tglKembali);

        // mengambil data barang yg bentrok return dari service cek jadwal
        $itemBentrok = $dataBentrokJadwal['barang']->filter(function ($item) {
            return $item['status'] === 'BENTROK';
        });

        // mengambil data ruangan yg bentrok return dari service cek jadwal
        $roomBentrok = $dataBentrokJadwal['ruangan']->filter(function ($room) {
            return $room['status'] === 'BENTROK';
        });

        $detailAgenda = new PengelolaanAgendaService();

        $riwayat = $detailAgenda->dataDetailAgenda($id);

        $dataAgendaPerhari = $riwayat;

        // dd($dataAgendaPerhari);

        // mengambil nama dari user yang sdng login
        $user = Auth::user()->nama;
        // menyimpan halaman variable
        $halaman = 'contentDetailAgenda';
        return view('Page_admin.dashboard-admin', compact(
            'halaman',
            'user',
            'dataDetailPengajuanPeminjaman',
            'tglPinjam',
            'tglKembali',
            'itemBentrok',
            'roomBentrok',
            'dataAgendaPerhari'
        ));
    }

    // kode untuk menampilkan halaman edit agenda
    public function HalamanEditAgenda($id)
    {
        $user = Auth::user()->nama;

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
            ->whereNotIn('status_usage_item', ['selesai', 'digunakan', 'ditolak'])
            ->get()
            ->unique('usage_items.id_item');

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
            ->whereNotIn('status_usage_room', ['selesai', 'digunakan', 'ditolak'])
            ->get()
            ->unique('usage_rooms.id_room');

        // menggabungkan data barang dan ruangan menjadi array
        $databarangruangan = $databarang->merge($dataruangan)->toArray();

        // ambil jam mulai dan jam selesainya saja 
        foreach ($databarangruangan as $item) {
            // Ambil jam mulai (cek item dulu, jika null ambil room)
            $jamMulai = $item->jam_mulai_usage_item ?? $item->jam_mulai_usage_room;

            // Ambil jam selesai
            $jamSelesai = $item->jam_selesai_usage_item ?? $item->jam_selesai_usage_room;
        }

        // menghilangkan jam_mulai dan jam_selesai dari array databarangruangan
        foreach ($databarangruangan as $item) {
            unset($item->jam_mulai_usage_room);
            unset($item->jam_selesai_usage_room);
        }

        // Menambah jam mulai dan jam selesai ke data agenda 
        $dataAgendas = $dataAgendas->toArray();

        $dataAgendas[0]->jam_mulai = $jamMulai;
        $dataAgendas[0]->jam_selesai = $jamSelesai;

        if ($jamMulai === null) {
            $dataAgendas[0]->tipe_jam = 'full day';
        } else {
            $dataAgendas[0]->tipe_jam = 'spesifik';
        }

        // dd($dataAgendas);

        // ambil id di session
        $sessionKode = session('kode_agenda_edit');

        // dd($sessionKode, $id);

        if (!session()->has('semua_data_edit_barang_ruang') || $sessionKode != $id) {

            // hapus session lama jika ada
            session()->forget(['semua_data_edit_barang_ruang', 'kode_agenda_edit']);

            // simpan array barang dan ruang ke session
            session(['semua_data_edit_barang_ruang' => $databarangruangan]);

            // // simpan array agenda ke session
            // session(['data_agenda_edit' => $dataAgenda->toArray()]);
        }

        if (!session()->has('data_agenda_edit') || $sessionKode != $id) {
            // hapus session lama jika ada
            session()->forget('data_agenda_edit');

            // simpan array agenda ke session
            session(['data_agenda_edit' => $dataAgendas]);
        }

        // simpan kode agenda ke session
        session(['kode_agenda_edit' => $id]);

        // ambil data dari session data brang dan ruang serta data agenda
        $semuaData = collect(session('semua_data_edit_barang_ruang'));
        $dataAgenda = collect(session('data_agenda_edit'));

        // dd($dataAgenda);

        // mengambil semua data barang dan ruangan
        $PengelolaanAgendaService = new PengelolaanAgendaService;
        $allBarangRuang = $PengelolaanAgendaService->getBarangDanRaung()->toArray();

        // dd($semuaData);

        // menyimpan halaman variable
        $halaman = 'contentEditAgenda';
        return view('Page_admin.dashboard-admin', compact(
            'halaman',
            'user',
            'id',
            'dataAgenda',
            'semuaData',
            'allBarangRuang',
            'jamMulai',
            'jamSelesai'
        ));
    }

    public function HalamanTambahAgenda(Request $request)
    {
        $dataAgendaTemp = $request->session()->get('data_input_agenda', []);
        $dataAgendaBarangTemp = $request->session()->get('data_input_barang', []);
        $dataAgendaRuanganTemp = $request->session()->get('data_input_ruangan', []);

        $dataBarang = DataBarang::join('rooms', 'items.id_room', 'rooms.id_room')
            ->select('items.*', 'rooms.nama_room')
            ->latest() // Pilih kolom yang diperlukan
            ->get();
        // dd($dataBarang);

        $dataRoom = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room')
            ->latest() // Pilih kolom yang diperlukan
            ->get();

        // dd($dataAgendaTemp);

        $user = Auth::user()->nama;
        $halaman = 'contentTambahAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataAgendaTemp', 'dataAgendaRuanganTemp', 'dataAgendaBarangTemp', 'dataBarang', 'dataRoom'));
    }

    // menyimpan data input agenda sementara sebelum di simpan di db agenda
    public function simpanInputAgendaTemporary(Request $request)
    {
        $dataAgenda = session('data_agenda_edit');
        // dd($request->all());

        $dataBaru = [
            'kode_agenda' => $request->kode_agenda,
            'nama_agenda' => $request->nama_agenda,
            'tgl_mulai_agenda' => $request->tgl_mulai_agenda,
            'tgl_selesai_agenda' => $request->tgl_selesai_agenda,
            'tipe_agenda' => $request->tipe_agenda,
            'loop_hari' => $request->loop_agenda,
            'jam_mulai' => $request->tipe_jam === 'spesifik' ? $request->jam_mulai : null,
            'jam_selesai' => $request->tipe_jam === 'spesifik' ? $request->jam_selesai : null,
            'tipe_jam' => $request->tipe_jam
        ];

        // simpan array ke session
        session()->put('data_agenda_edit', [(object) $dataBaru]);

        // Opsional: Paksa simpan session sebelum redirect
        session()->save();

        // dd(session('data_agenda_edit'), $dataAgenda);

        // $request->session()->forget('data_input_agenda');
        // // 1. Ambil data yang sudah ada di session (jika ada)
        // $currentData = $request->session()->get('data_input_agenda', []);

        // // 2. Tambahkan data baru dari form
        // $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF

        // // 3. Simpan kembali array yang diperbarui ke session
        // $request->session()->put('data_input_agenda', $currentData);

        // // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
        return redirect()->back()->with('success', 'Data berhasil ditambahkan sementara.');
    }

    // menyimpan data input barang dan ruangan sementara sebelum disimpan di db usage item
    public function simpanInputBarangAgendaTemporary(Request $request)
    {
        $request->validate([
            'id_item_room' => 'required',
            'id_agenda' => 'required',
        ]);

        $itemcek = DB::table('items')
            ->where('id_item', $request->id_item_room)
            ->count();

        // cek apakah yg di inputkan item jika item menjalankan if ini
        if ($itemcek > 0) {
            if ($request->qty_usage < 1) {
                return redirect()->back()->with('gagal', 'pastikan qty barang yang ingin digunakan tidak 0');
            } elseif ($request->qty_usage > $request->qty_item) {
                return redirect()->back()->with('gagal', 'qty barang yang anda masukkan melebihi stok yang ada!');
            }
        }

        // dd($request->all());

        // data barang dan ruang yg ada di session
        $data = session('semua_data_edit_barang_ruang');

        $inputUser = $request->id_item_room; // Kode yang dicari

        // cek apakah id_item atau id_room sudah ada di array session
        if (collect($data)->firstWhere('id_room', $inputUser) || collect($data)->firstWhere('id_item', $inputUser)) {
            // Jika ketemu, kembalikan pesan eror
            return redirect()->back()->with('gagal', 'barang atau ruangan yang ada pilih sudah ada di daftar sementara.');
        }

        // data barang atau ruang dari db berdasarkan id_item_room yg di inputkan
        $databarang = DB::table('items')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->select(
                'items.id_item',
                'items.nama_item',
                'items.img_item',
                'items.kondisi_item',
                'tipe_item.nama_tipe_item'
            )
            ->where('items.id_item', $inputUser)
            ->get();

        $dataruang = DB::table('rooms')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select(
                'rooms.id_room',
                'rooms.nama_room',
                'rooms.gambar_room',
                'rooms.kondisi_room',
                'tipe_rooms.nama_tipe_room'
            )
            ->where('rooms.id_room', $inputUser)
            ->get();

        $dataColection = collect($data);

        // jika item yg di inputkan maka push qty_usage di session databarangruang
        if ($itemcek > 0) {
            $databarang[0]->qty_usage_item = $request->qty_usage;
        }

        // dd($databarang);

        $dataColectionBarangRuang = $databarang->concat($dataruang);

        // dd($dataColectionBarangRuang);

        // simpan array ke session
        session()->put('semua_data_edit_barang_ruang', $dataColection->concat($dataColectionBarangRuang)->toArray());

        // Opsional: Paksa simpan session sebelum redirect
        session()->save();
        // session(['semua_data_edit_barang_ruang' => $dataColection->concat($dataColectionBarangRuang)->toArray()]);

        // return redirect()->route('edit-agenda-admin', ['id' => $request->id_agenda])->with('success', 'Data barang berhasil ditambahkan sementara.');
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan sementara.');
    }
    // hapus input barang dan ruangan temp
    public function hapusInputBarangAgendaTemporary(Request $request)
    {
        $request->validate([
            'id_item_room' => 'required',
        ]);

        $idHapus = $request->id_item_room;

        $data = session('semua_data_edit_barang_ruang');

        $dataTerupdate = collect($data)->reject(function ($item) use ($idHapus) {
            // Cek apakah ID ada di id_item ATAU id_room
            return ($item->id_item ?? null) == $idHapus || ($item->id_room ?? null) == $idHapus;
        })->values(); // values() digunakan untuk meriset ulang index array agar tetap 0, 1, 2...

        // Simpan kembali ke session
        session(['semua_data_edit_barang_ruang' => $dataTerupdate->toArray()]);

        // dd($data);

        // // mengambil data input barang temp yg ada di session
        // $dataAgendaBarangTemp = $request->session()->get('data_input_barang', []);

        // //loop untuk mencari id_item yg di input
        // foreach ($dataAgendaBarangTemp as $key => $dataInputBarang) {

        //     if ($dataInputBarang['id_item'] === $request->id_item) {
        //         unset($dataAgendaBarangTemp[$key]);
        //     }
        // }

        // $dataAgendaBarangTemp = array_values($dataAgendaBarangTemp);
        // $request->session()->put('data_input_barang', $dataAgendaBarangTemp);

        return redirect()->back()->with('gagal', 'Barang atau ruangan berhasil dihapus dari daftar.');
    }

    // // menyimpan data input ruangan sementara sebelum disimpan di db usage room
    // public function simpanInputRuanganAgendaTemporary(Request $request)
    // {
    //     // ambil id_item dari request form
    //     $request->validate([
    //         'id_room' => 'required',
    //     ]);

    //     // memastikan data input agenda temp sudah di isi dahulu sebelum mengisi data barang dan ruang
    //     if ($request->session()->get('data_input_agenda', []) === []) {
    //         return redirect()->back()->with('gagal', 'pastikan data agenda sudah di isi terlebih dahulu!!');
    //     }

    //     $dataRuangan = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', 'tipe_rooms.id_tipe_room')
    //         ->select('rooms.*', 'tipe_rooms.nama_tipe_room')
    //         ->where('id_room', '=', $request->id_room) // Pilih kolom yang diperlukan
    //         ->get();

    //     //ambil nama room
    //     $nama_room = $dataRuangan[0]->nama_room;
    //     //ambil nama tipe room
    //     $nama_tipe_room = $dataRuangan[0]->nama_tipe_room;

    //     // Ambil data yang sudah ada di session (jika ada) ini tidak berisi nama room
    //     $currentData = $request->session()->get('data_input_ruangan', []);

    //     // ambil jmlh aray dari array barangTemp
    //     $jmlhArray = count($currentData);

    //     // Tambahkan data baru dari form
    //     $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF

    //     // tambah nama room ke dalam array 
    //     $currentData[$jmlhArray]['nama_room'] = $nama_room;
    //     $currentData[$jmlhArray]['nama_tipe_room'] = $nama_tipe_room;

    //     // Simpan kembali array yang diperbarui ke session
    //     $request->session()->put('data_input_ruangan', $currentData);

    //     // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
    //     return redirect()->back()->with('success', 'Data barang berhasil ditambahkan sementara.');
    // }
    // // hapus input Ruangan temp
    // public function hapusInputRuanganAgendaTemporary(Request $request)
    // {
    //     $request->validate([
    //         'id_room' => 'required',
    //     ]);

    //     // mengambil data input barang temp yg ada di session
    //     $dataAgendaRuanganTemp = $request->session()->get('data_input_ruangan', []);

    //     //loop untuk mencari id_room yg di input
    //     foreach ($dataAgendaRuanganTemp as $key => $dataInputRuangan) {

    //         if ($dataInputRuangan['id_room'] === $request->id_room) {
    //             unset($dataAgendaRuanganTemp[$key]);
    //         }
    //     }

    //     $dataAgendaRuanganTemp = array_values($dataAgendaRuanganTemp);
    //     $request->session()->put('data_input_ruangan', $dataAgendaRuanganTemp);

    //     return redirect()->back()->with('gagal', 'Ruangan berhasil dihapus dari daftar sementara.');
    // }

    // simpan agenda dan semua barang dan ruangan yg d gunakan ke db
    public function simpanAgendaTemporary(Request $request)
    {
        // data id admin/staff
        $iduser = Auth::user()->id_user;
        // kode agenda lama
        $kode_agenda_lama = $request->kode_agenda_lama;

        // dd($kode_agenda_lama);

        // ambil data dari session data brang dan ruang serta data agenda
        $semuaDataBrngRuang = session('semua_data_edit_barang_ruang');
        $dataAgenda = session('data_agenda_edit');

        // get data agenda disimpan ke variable
        $kode_agenda = $dataAgenda[0]->kode_agenda;
        $nama_agenda = $dataAgenda[0]->nama_agenda;
        $tgl_mulai = $dataAgenda[0]->tgl_mulai_agenda;
        $tgl_selesai = $dataAgenda[0]->tgl_selesai_agenda;
        $loop_hari = $dataAgenda[0]->loop_hari;
        $jam_mulai = $dataAgenda[0]->jam_mulai;
        $jam_selesai = $dataAgenda[0]->jam_selesai;
        $tipe_jam = $dataAgenda[0]->tipe_jam;

        // dd($semuaDataBrngRuang);

        // perulangan usage room atau barang jika setiap hari atau perminggu
        if ($dataAgenda[0]->loop_hari === 'setiap hari') {

            // perulangan setiap hari tertentu misal hari senin agenda itu akan berulang setiap hari senin saja sampai waktu yg sudah d tentukan

            DB::beginTransaction();

            try {
                // Update table agenda fakultas
                DB::table('agenda_fakultas')
                    ->where('kode_agenda',)
                    ->update([
                        'kode_agenda' => $kode_agenda,
                        'id_user' => $iduser,
                        'nama_agenda' => $nama_agenda,
                        'tgl_mulai_agenda' => $tgl_mulai,
                        'tgl_selesai_agenda' => $tgl_selesai,
                        'tipe_agenda' => $nama_agenda,
                        'loop_hari' => $loop_hari,
                        'updated_at' => now()
                    ]);

                // hapus data usage room atau item yg lama selain yg statusnya sedang digunakan dan sudah selesai
                DB::table('usage_rooms')->where('kode_agenda', $kode_agenda_lama)->where('status_usage_room', 'terjadwal')->delete();
                DB::table('usage_items')->where('kode_agenda', $kode_agenda_lama)->where('status_usage_item', 'terjadwal')->delete();

                // 3. Siapkan daftar tanggal (Hanya ini loop yang diperlukan untuk logika bisnis)
                $mapHari = [
                    'senin'  => 'monday',
                    'selasa' => 'tuesday',
                    'rabu'   => 'wednesday',
                    'kamis'  => 'thursday',
                    'jumat'  => 'friday',
                    'sabtu'  => 'saturday',
                    'minggu' => 'sunday',
                ];

                // ubah nama hari menjadi menggunakan b.inggris
                $hariInggris = $mapHari[strtolower($loop_hari)] ?? strtolower($loop_hari);

                $targetDates = [];

                // berjlan hanya jika hari ini sudah melewati tgl agenda berfungsi agar saat menginputkan data baru tidak redudant dengan data yg sudah terlewat
                if (Carbon::parse($tgl_mulai)->startOfDay() < now()) {
                    $end = Carbon::parse($tgl_selesai)->endOfDay();
                    $period = CarbonPeriod::create(now(), $end);
                } else {
                    $start = Carbon::parse($tgl_mulai)->startOfDay();
                    $end = Carbon::parse($tgl_selesai)->endOfDay();
                    $period = CarbonPeriod::create($start, $end);
                }

                // menyimpan tgl setiap hari tertentu yg di inputkan user
                foreach ($period as $date) {
                    // if (strtolower($date->translatedFormat('l')) == strtolower($hariInggris)) {
                        $targetDates[] = $date->format('Y-m-d');
                    // }
                }

                // dd($targetDates);

                // memisahkan Data Room dan Data Item dari Array Campuran
                $finalRooms = [];
                $finalItems = [];

                foreach ($targetDates as $tanggal) {
                    foreach ($semuaDataBrngRuang as $data) {

                        // Cek apakah ini objek Room (memiliki id_room)
                        if (isset($data->id_room)) {
                            $finalRooms[] = [
                                'kode_peminjaman' => null,
                                'kode_agenda' => $kode_agenda,
                                'id_room'     => $data->id_room,
                                'tgl_pinjam_usage_room'   => $tanggal . ' 00:00:00',
                                'tgl_kembali_usage_room'   => $tanggal . ' 23:59:00',
                                'status_usage_room'   => 'terjadwal',
                                'created_at'  => now(),
                                'updated_at'  => now(),
                                'jam_mulai_usage_room'  => $jam_mulai,
                                'jam_selesai_usage_room'  => $jam_selesai,
                            ];
                        }
                        // Cek apakah ini objek Item (memiliki id_item)
                        elseif (isset($data->id_item)) {
                            $finalItems[] = [
                                'kode_peminjaman' => null,
                                'kode_agenda' => $kode_agenda,
                                'id_item'     => $data->id_item,
                                'qty_usage_item' => $data->qty_usage_item,
                                'tgl_pinjam_usage_item'   => $tanggal . ' 00:00:00',
                                'tgl_kembali_usage_item'   => $tanggal . ' 23:59:00',
                                'status_usage_item'   => 'terjadwal',
                                'created_at'  => now(),
                                'updated_at'  => now(),
                                'jam_mulai_usage_item'  => $jam_mulai,
                                'jam_selesai_usage_item'  => $jam_selesai,
                            ];
                        }
                    }
                }

                // dd($finalRooms, $finalItems);

                // Insert Sekaligus ke db
                if (!empty($finalRooms)) DB::table('usage_rooms')->insert($finalRooms);
                if (!empty($finalItems)) DB::table('usage_items')->insert($finalItems);

                DB::commit();
                return redirect()->back()->with('success', 'berhasil memperbarui agenda!');
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage()], 500);
            }

        } else {
            // perulangan setiap hari tertentu misal hari senin agenda itu akan berulang setiap hari senin saja sampai waktu yg sudah d tentukan

            DB::beginTransaction();

            try {
                // Update table agenda fakultas
                DB::table('agenda_fakultas')
                    ->where('kode_agenda',)
                    ->update([
                        'kode_agenda' => $kode_agenda,
                        'id_user' => $iduser,
                        'nama_agenda' => $nama_agenda,
                        'tgl_mulai_agenda' => $tgl_mulai,
                        'tgl_selesai_agenda' => $tgl_selesai,
                        'tipe_agenda' => $nama_agenda,
                        'loop_hari' => $loop_hari,
                        'updated_at' => now()
                    ]);

                // hapus data usage room atau item yg lama selain yg statusnya sedang digunakan dan sudah selesai
                DB::table('usage_rooms')->where('kode_agenda', $kode_agenda_lama)->where('status_usage_room', 'terjadwal')->delete();
                DB::table('usage_items')->where('kode_agenda', $kode_agenda_lama)->where('status_usage_item', 'terjadwal')->delete();

                // 3. Siapkan daftar tanggal (Hanya ini loop yang diperlukan untuk logika bisnis)
                $mapHari = [
                    'senin'  => 'monday',
                    'selasa' => 'tuesday',
                    'rabu'   => 'wednesday',
                    'kamis'  => 'thursday',
                    'jumat'  => 'friday',
                    'sabtu'  => 'saturday',
                    'minggu' => 'sunday',
                ];

                // ubah nama hari menjadi menggunakan b.inggris
                $hariInggris = $mapHari[strtolower($loop_hari)] ?? strtolower($loop_hari);

                $targetDates = [];

                // berjlan hanya jika hari ini sudah melewati tgl agenda berfungsi agar saat menginputkan data baru tidak redudant dengan data yg sudah terlewat
                if (Carbon::parse($tgl_mulai)->startOfDay() < now()) {
                    $end = Carbon::parse($tgl_selesai)->endOfDay();
                    $period = CarbonPeriod::create(now(), $end);
                } else {
                    $start = Carbon::parse($tgl_mulai)->startOfDay();
                    $end = Carbon::parse($tgl_selesai)->endOfDay();
                    $period = CarbonPeriod::create($start, $end);
                }

                // menyimpan tgl setiap hari tertentu yg di inputkan user
                foreach ($period as $date) {
                    if (strtolower($date->translatedFormat('l')) == strtolower($hariInggris)) {
                        $targetDates[] = $date->format('Y-m-d');
                    }
                }

                // dd($targetDates);

                // memisahkan Data Room dan Data Item dari Array Campuran
                $finalRooms = [];
                $finalItems = [];

                foreach ($targetDates as $tanggal) {
                    foreach ($semuaDataBrngRuang as $data) {

                        // Cek apakah ini objek Room (memiliki id_room)
                        if (isset($data->id_room)) {
                            $finalRooms[] = [
                                'kode_peminjaman' => null,
                                'kode_agenda' => $kode_agenda,
                                'id_room'     => $data->id_room,
                                'tgl_pinjam_usage_room'   => $tanggal . ' 00:00:00',
                                'tgl_kembali_usage_room'   => $tanggal . ' 23:59:00',
                                'status_usage_room'   => 'terjadwal',
                                'created_at'  => now(),
                                'updated_at'  => now(),
                                'jam_mulai_usage_room'  => $jam_mulai,
                                'jam_selesai_usage_room'  => $jam_selesai,
                            ];
                        }
                        // Cek apakah ini objek Item (memiliki id_item)
                        elseif (isset($data->id_item)) {
                            $finalItems[] = [
                                'kode_peminjaman' => null,
                                'kode_agenda' => $kode_agenda,
                                'id_item'     => $data->id_item,
                                'qty_usage_item' => $data->qty_usage_item,
                                'tgl_pinjam_usage_item'   => $tanggal . ' 00:00:00',
                                'tgl_kembali_usage_item'   => $tanggal . ' 23:59:00',
                                'status_usage_item'   => 'terjadwal',
                                'created_at'  => now(),
                                'updated_at'  => now(),
                                'jam_mulai_usage_item'  => $jam_mulai,
                                'jam_selesai_usage_item'  => $jam_selesai,
                            ];
                        }
                    }
                }

                // dd($finalRooms, $finalItems);

                // Insert Sekaligus ke db
                if (!empty($finalRooms)) DB::table('usage_rooms')->insert($finalRooms);
                if (!empty($finalItems)) DB::table('usage_items')->insert($finalItems);

                DB::commit();
                return redirect()->back()->with('success', 'berhasil memperbarui agenda!');
            } catch (\Exception $e) {
                DB::rollback();
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }


        // // ambil data array agenda temp
        // $dataAgendaTemp = $request->session()->get('data_input_agenda', []);
        // // get data agenda
        // $nama_agenda = $dataAgendaTemp[0]['nama_agenda'];
        // $tipe_agenda = $dataAgendaTemp[0]['tipe'];
        // $tgl_mulai = $dataAgendaTemp[0]['tgl-mulai'];
        // $tgl_sellesai = $dataAgendaTemp[0]['tgl-selesai'];

        // // generate id agenda dari nama dan tipe agenda
        // $GenerateIdAgenda = new agendaFakultas();
        // $kode_agenda = $GenerateIdAgenda->generateIdAgenda($nama_agenda, $tipe_agenda);

        // //simpan agenda ke db
        // agendaFakultas::create([
        //     'kode_agenda' => $kode_agenda,
        //     'id_user' => $iduser,
        //     'nama_agenda' => $nama_agenda,
        //     'tgl_mulai_agenda' => $tgl_mulai,
        //     'tgl_selesai_agenda' => $tgl_sellesai,
        //     'tipe_agenda' => $tipe_agenda,
        //     'created_at' => now(),
        //     'updated_at' => now()
        // ]);

        // // mengambil data input agenda repeat mingguan/harian dalam agenda tersebut
        // if ($dataAgendaTemp[0]['repeat'] === 'mingguan') {
        //     // menyimpan data jika inputan agenda dijalankan 1 kali dalam 1 minggu
        //     $this->simpanWeek($request, $dataAgendaTemp[0]['tgl-mulai'], $dataAgendaTemp[0]['tgl-selesai'], $dataAgendaTemp[0]['jam_mulai'], $dataAgendaTemp[0]['jam_selesai'], $kode_agenda);
        //     // kembali ke halaman agenda
        //     return redirect()->route('dashboard-admin-agenda')->with('success', 'Data berhasil di simpan.');
        // } elseif ($dataAgendaTemp[0]['repeat'] === 'harian') {
        //     // meyimpan data jika inputan agenda dijalankan 1 kali dalam 1 hari
        //     dd($dataAgendaTemp[0]['repeat']);
        // }
    }

    // menghapus agenda dari db di table agenda fakultas dan menghapus usage nya di usage barang dan ruangan
    public function hapusAgenda(Request $request)
    {
        $request->validate([
            'kode_agenda' => 'required',
        ]);

        // dd($request->kode_agenda);

        $hapusUsageItem = UsageItems::where('kode_agenda', '=', $request->kode_agenda)->delete();
        $hapusUsageRoom = UsageRooms::where('kode_agenda', '=', $request->kode_agenda)->delete();
        $hapusAgenda = agendaFakultas::where('kode_agenda', '=', $request->kode_agenda)->delete();

        return redirect()->route('dashboard-admin-agenda')->with('success', 'Data berhasil di hapus.');
    }
}
