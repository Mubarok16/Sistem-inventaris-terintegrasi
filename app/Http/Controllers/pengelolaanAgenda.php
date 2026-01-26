<?php

namespace App\Http\Controllers;

use App\Imports\AgendaImport;
use App\Models\agendaFakultas;
use App\Models\DataBarang;
use App\Models\DataRuangan;
use App\Models\UsageItems;
use App\Models\UsageRooms;
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
                        'tgl_pinjam_usage_room' => $currentDate,
                        'tgl_kembali_usage_room' => $currentDate,
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

        // mengambil data agenda dari table agenda
        $DataAgenda = DB::table('agenda_fakultas') // Pilih kolom yang diperlukan
            ->join('users', 'agenda_fakultas.id_user', '=', 'users.id_user')
            ->select('agenda_fakultas.*', 'users.nama')
            ->where('agenda_fakultas.kode_agenda', '=', $id)
            ->latest()
            ->get();

        // mengambil data usage barang dari table usage barang
        $dataDetailUsageBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select('usage_items.*', 'items.nama_item') // Pilih kolom yang diperlukan
            ->where('usage_items.kode_agenda', $id)
            ->get();

        // mengambil data usage ruangan dari table usage ruangan
        $dataDetailUsageRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('usage_rooms.*', 'rooms.nama_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_agenda', $id)
            ->get();

        // dd($DataAgenda);
        // mengambil nama dari user yang sdng login
        $user = Auth::user()->nama;
        // menyimpan halaman variable
        $halaman = 'contentDetailAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'DataAgenda', 'dataDetailUsageBarang', 'dataDetailUsageRuangan'));
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
        $request->session()->forget('data_input_agenda');
        // 1. Ambil data yang sudah ada di session (jika ada)
        $currentData = $request->session()->get('data_input_agenda', []);

        // 2. Tambahkan data baru dari form
        $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF

        // 3. Simpan kembali array yang diperbarui ke session
        $request->session()->put('data_input_agenda', $currentData);

        // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
        return redirect()->back()->with('success', 'Data berhasil ditambahkan sementara.');
    }

    // menyimpan data input barang sementara sebelum disimpan di db usage item
    public function simpanInputBarangAgendaTemporary(Request $request)
    {
        $request->validate([
            'id_item' => 'required',
        ]);

        // memastikan data input agenda temp sudah di isi dahulu sebelum mengisi data barang dan ruang
        if ($request->session()->get('data_input_agenda', []) === []) {
            return redirect()->back()->with('gagal', 'pastikan data agenda sudah di isi terlebih dahulu!!');
        }

        $dataBarang = DataBarang::join('rooms', 'items.id_room', 'rooms.id_room')
            ->select('items.*', 'rooms.nama_room')
            ->where('id_item', '=', $request->id_item) // Pilih kolom yang diperlukan
            ->get();
        //ambil nama item
        $nama_item = $dataBarang[0]->nama_item;
        //ambil data tempat menyimpan
        $nama_room = $dataBarang[0]->nama_room;

        // Ambil data yang sudah ada di session (jika ada)
        $currentData = $request->session()->get('data_input_barang', []);
        // ambil jmlh aray dari array barangTemp
        $jmlhArray = count($currentData);
        // Tambahkan data baru dari form
        $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF
        // tambah nama item ke dalam array 
        $currentData[$jmlhArray]['nama_item'] = $nama_item;
        // tambah nama_room ke array temp
        $currentData[$jmlhArray]['nama_room'] = $nama_room;

        // dd($currentData);
        // 3. Simpan kembali array yang diperbarui ke session
        $request->session()->put('data_input_barang', $currentData);

        // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan sementara.');
    }
    // hapus input barang temp
    public function hapusInputBarangAgendaTemporary(Request $request)
    {
        $request->validate([
            'id_item' => 'required',
        ]);

        // mengambil data input barang temp yg ada di session
        $dataAgendaBarangTemp = $request->session()->get('data_input_barang', []);

        //loop untuk mencari id_item yg di input
        foreach ($dataAgendaBarangTemp as $key => $dataInputBarang) {

            if ($dataInputBarang['id_item'] === $request->id_item) {
                unset($dataAgendaBarangTemp[$key]);
            }
        }

        $dataAgendaBarangTemp = array_values($dataAgendaBarangTemp);
        $request->session()->put('data_input_barang', $dataAgendaBarangTemp);

        return redirect()->back()->with('gagal', 'Barang berhasil dihapus dari daftar sementara.');
    }

    // menyimpan data input ruangan sementara sebelum disimpan di db usage room
    public function simpanInputRuanganAgendaTemporary(Request $request)
    {
        // ambil id_item dari request form
        $request->validate([
            'id_room' => 'required',
        ]);

        // memastikan data input agenda temp sudah di isi dahulu sebelum mengisi data barang dan ruang
        if ($request->session()->get('data_input_agenda', []) === []) {
            return redirect()->back()->with('gagal', 'pastikan data agenda sudah di isi terlebih dahulu!!');
        }

        $dataRuangan = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room')
            ->where('id_room', '=', $request->id_room) // Pilih kolom yang diperlukan
            ->get();

        //ambil nama room
        $nama_room = $dataRuangan[0]->nama_room;
        //ambil nama tipe room
        $nama_tipe_room = $dataRuangan[0]->nama_tipe_room;

        // Ambil data yang sudah ada di session (jika ada) ini tidak berisi nama room
        $currentData = $request->session()->get('data_input_ruangan', []);

        // ambil jmlh aray dari array barangTemp
        $jmlhArray = count($currentData);

        // Tambahkan data baru dari form
        $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF

        // tambah nama room ke dalam array 
        $currentData[$jmlhArray]['nama_room'] = $nama_room;
        $currentData[$jmlhArray]['nama_tipe_room'] = $nama_tipe_room;

        // Simpan kembali array yang diperbarui ke session
        $request->session()->put('data_input_ruangan', $currentData);

        // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan sementara.');
    }
    // hapus input Ruangan temp
    public function hapusInputRuanganAgendaTemporary(Request $request)
    {
        $request->validate([
            'id_room' => 'required',
        ]);

        // mengambil data input barang temp yg ada di session
        $dataAgendaRuanganTemp = $request->session()->get('data_input_ruangan', []);

        //loop untuk mencari id_room yg di input
        foreach ($dataAgendaRuanganTemp as $key => $dataInputRuangan) {

            if ($dataInputRuangan['id_room'] === $request->id_room) {
                unset($dataAgendaRuanganTemp[$key]);
            }
        }

        $dataAgendaRuanganTemp = array_values($dataAgendaRuanganTemp);
        $request->session()->put('data_input_ruangan', $dataAgendaRuanganTemp);

        return redirect()->back()->with('gagal', 'Ruangan berhasil dihapus dari daftar sementara.');
    }

    // simpan agenda temp ke db
    public function simpanAgendaTemporary(Request $request)
    {
        // data id admin/staff
        $iduser = Auth::user()->id_user;
        // ambil data array agenda temp
        $dataAgendaTemp = $request->session()->get('data_input_agenda', []);
        // get data agenda
        $nama_agenda = $dataAgendaTemp[0]['nama_agenda'];
        $tipe_agenda = $dataAgendaTemp[0]['tipe'];
        $tgl_mulai = $dataAgendaTemp[0]['tgl-mulai'];
        $tgl_sellesai = $dataAgendaTemp[0]['tgl-selesai'];

        // generate id agenda dari nama dan tipe agenda
        $GenerateIdAgenda = new agendaFakultas();
        $kode_agenda = $GenerateIdAgenda->generateIdAgenda($nama_agenda, $tipe_agenda);

        //simpan agenda ke db
        agendaFakultas::create([
            'kode_agenda' => $kode_agenda,
            'id_user' => $iduser,
            'nama_agenda' => $nama_agenda,
            'tgl_mulai_agenda' => $tgl_mulai,
            'tgl_selesai_agenda' => $tgl_sellesai,
            'tipe_agenda' => $tipe_agenda,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // mengambil data input agenda repeat mingguan/harian dalam agenda tersebut
        if ($dataAgendaTemp[0]['repeat'] === 'mingguan') {
            // menyimpan data jika inputan agenda dijalankan 1 kali dalam 1 minggu
            $this->simpanWeek($request, $dataAgendaTemp[0]['tgl-mulai'], $dataAgendaTemp[0]['tgl-selesai'], $dataAgendaTemp[0]['jam_mulai'], $dataAgendaTemp[0]['jam_selesai'], $kode_agenda);
            // kembali ke halaman agenda
            return redirect()->route('dashboard-admin-agenda')->with('success', 'Data berhasil di simpan.');
        } elseif ($dataAgendaTemp[0]['repeat'] === 'harian') {
            // meyimpan data jika inputan agenda dijalankan 1 kali dalam 1 hari
            dd($dataAgendaTemp[0]['repeat']);
        }
    }

    // menghapus agenda dari db di table agenda fakultas dan menghapus usage nya di usage barang dan ruangan
    public function hapusAgenda(Request $request)
    {
        $request->validate([
            'kode_agenda' => 'required',
        ]);

        $hapusUsageItem = UsageItems::where('kode_agenda', '=', $request->kode_agenda)->delete();
        $hapusUsageRoom = UsageRooms::where('kode_agenda', '=', $request->kode_agenda)->delete();
        $hapusAgenda = agendaFakultas::where('kode_agenda', '=', $request->kode_agenda)->delete();

        return redirect()->route('dashboard-admin-agenda')->with('success', 'Data berhasil di hapus.');
    }
}
