<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class pengelolaanAgenda extends Controller
{
    //belum jadi
    public function tambahAgenda(Request $request)
    {
        $Data = DB::table('agenda_fakultas') // Pilih kolom yang diperlukan
            ->where('kode_agenda', 'AKDK-TKM-SJK')
            ->latest()
            ->get();

        $mulai = $Data[0]->tgl_mulai_agenda;
        $akhir = $Data[0]->tgl_selesai_agenda;

        $startDate = Carbon::parse($mulai); // Senin
        $endDate = Carbon::parse($akhir); // Minggu
        $targetDayOfWeek = $startDate->dayOfWeek; // Mengambil angka hari dari $startDate (yaitu 1 untuk Senin)

        $agendasToCreate = [];
        $currentDate = $startDate->copy();

        // Loop dari Tanggal Mulai hingga Tanggal Akhir
        while ($currentDate->lessThanOrEqualTo($endDate)) {

            // ✅ KOREKSI: Bandingkan angka hari dalam seminggu
            if ($currentDate->dayOfWeek === $targetDayOfWeek) {

                // --- BUAT AGENDA UNTUK HARI INI ---
                $agendasToCreate[] = [
                    'tgl_mulai_usage' => $currentDate->copy()->setTime(9, 0, 0)->toDateTimeString(),
                    'tgl_selesai_usage' => $currentDate->copy()->setTime(10, 0, 0)->toDateTimeString(),
                ];
            }

            // Pindah ke hari berikutnya
            $currentDate->addDay();
        }
        dd($agendasToCreate);
    }

    //return halaman detail agenda
    public function DetailAgenda($id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $DataAgenda = DB::table('agenda_fakultas') // Pilih kolom yang diperlukan
            ->join('users', 'agenda_fakultas.id_user', '=', 'users.id_user')
            ->select('agenda_fakultas.*', 'users.nama')
            ->where('agenda_fakultas.kode_agenda', '=', $id)
            ->latest()
            ->get();

        $dataDetailUsageBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select('usage_items.*', 'items.nama_item') // Pilih kolom yang diperlukan
            ->where('usage_items.kode_agenda', $id)
            ->get();

        $dataDetailUsageRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('usage_rooms.*', 'rooms.nama_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_agenda', $id)
            ->get();
        // dd($dataDetailUsageRuangan);

        // dd($DataAgenda);

        $user = Auth::user()->nama;
        $halaman = 'contentDetailAgenda';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'DataAgenda', 'dataDetailUsageBarang', 'dataDetailUsageRuangan'));
    }

    public function HalamanTambahAgenda(Request $request)
    {
        $dataAgendaTemp = $request->session()->get('data_input_agenda', []);
        $dataAgendaBarangTemp = $request->session()->get('data_input_barang', []);
        $dataAgendaRuanganTemp = $request->session()->get('data_input_ruangan', []);

        $dataBarang = DB::table('items')
            ->latest() // Pilih kolom yang diperlukan
            ->get();

        $dataRoom = DB::table('rooms')
            ->latest() // Pilih kolom yang diperlukan
            ->get();

        // dd($dataAgendaBarangTemp);

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

        $dataBarang = DB::table('items')
            ->where('id_item', '=', $request->id_item) // Pilih kolom yang diperlukan
            ->get();
        //ambil nama item
        $nama_item = $dataBarang[0]->nama_item;

        // 1. Ambil data yang sudah ada di session (jika ada)
        $currentData = $request->session()->get('data_input_barang', []);
        $jmlhArray = count($currentData);
        // 2. Tambahkan data baru dari form
        $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF
        $currentData[$jmlhArray]['nama_item'] = $nama_item;
        // dd($currentData);

        // 3. Simpan kembali array yang diperbarui ke session
        $request->session()->put('data_input_barang', $currentData);

        // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan sementara.');
    }

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

    // menyimpan data input barang sementara sebelum disimpan di db usage room
    public function simpanInputRuanganAgendaTemporary(Request $request)
    {
        // 1. Ambil data yang sudah ada di session (jika ada)
        $currentData = $request->session()->get('data_input_ruangan', []);

        // 2. Tambahkan data baru dari form
        $currentData[] = $request->except('_token'); // Tambahkan semua input kecuali token CSRF

        // 3. Simpan kembali array yang diperbarui ke session
        $request->session()->put('data_input_ruangan', $currentData);

        // Kirim respons, mungkin ke halaman form berikutnya atau halaman konfirmasi
        return redirect()->back()->with('success', 'Data barang berhasil ditambahkan sementara.');
    }
}
