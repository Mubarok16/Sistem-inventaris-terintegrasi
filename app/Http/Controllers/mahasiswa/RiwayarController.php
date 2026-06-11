<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\UsageItems;
use App\Models\UsageRooms;
use App\Services\Admin\PengelolaanPeminjamanService;
use App\Services\mahasiswa\RiwayatPeminjamanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class RiwayarController extends Controller
{
    // method untuk menampilkan data riwayat by satatus
    public function SimpanSessionriwayatByStatus(Request $request)
    {
        $status = $request->input('status');

        session()->put('status-riwayat', $status);

        return back();
    }

    public function mahasiswaRiwayatDetail($id)
    {

        $dataDetailPengajuanPeminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->select('peminjaman.*', 'peminjam.nama_peminjam', 'peminjam.no_identitas', 'peminjam.fakultas', 'peminjam.prodi') // Pilih kolom yang diperlukan
            ->where('peminjaman.kode_peminjaman', $id)
            ->get();

        $detailBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select(
                'usage_items.*', 
                'items.nama_item', 
                'items.id_item', 
                'items.kondisi_item', 
                'items.img_item'
            ) // Pilih kolom yang diperlukan
            ->where('usage_items.kode_peminjaman', $id)
            ->first();

        $detailRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_peminjaman', $id)
            ->first();

        // dd($detailBarang);

        // mengambil tgl pinjam dan tgl kembali dari usage_items dan usage_rooms
        $tglPinjamItem = DB::table('usage_items')
            ->select('tgl_pinjam_usage_item', 'tgl_kembali_usage_item')
            ->where('kode_peminjaman', $id)
            ->get();

        $tglPinjamRoom = DB::table('usage_rooms')
            ->select('tgl_pinjam_usage_room', 'tgl_kembali_usage_room')
            ->where('kode_peminjaman', $id)
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

        $tglPinjam = null;
        $tglKembali = null;

        // if ($tglPinjamItem) {
        foreach ($dataDetailPengajuanPeminjaman as $value) {
            $tglPinjam = $value->tgl_pinjam;
            $tglKembali = $value->tgl_kembali;
        }
        // } else {
        foreach ($dataDetailPengajuanPeminjaman as $value) {
            $tglPinjam = $value->tgl_pinjam;
            $tglKembali = $value->tgl_kembali;
        }
        // }   

        $riwayatPeminjamanService = new RiwayatPeminjamanService();

        $riwayat = $riwayatPeminjamanService->dataDetailPeminjaman($id);

        $DetailRiwayatPerHari = $riwayat;
        // dd($DetailRiwayatPerHari);

        // dd($dataDetailPengajuanPeminjamanBarang, $dataDetailPengajuanPeminjamanRuangan);

        // simpan id di session
        session()->put('id_peminjaman_agenda', $id);

        $tglStartKalender = $dataDetailPengajuanPeminjaman[0]->tgl_pinjam;

        // dd($tglStartKalender);

        $user = DB::table('peminjam')->where('id_user', Auth::user()->id_user)->value('nama_peminjam');
        $halaman = 'contentRiwayatDetail';
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'DetailRiwayatPerHari', 'dataDetailPengajuanPeminjaman', 'detailBarang', 'detailRuangan', 'tglPinjam', 'tglKembali', 'itemBentrok', 'roomBentrok', 'tglStartKalender'));
    }

    // public function QrDanBatalPeminjaman(Request $request)
    // {
    //     $kode_peminjaman = $request->input('kode_peminjaman');
    //     $status_peminjaman = $request->input('status_peminjaman');
    //     $aksi = $request->input('aksi');

    //     // mengambil data usage room dan usage item 
    //     // 1. Ambil data mentah dari database
    //     // $dataUsageRoom = DB::table('usage_rooms')
    //     //     ->select('tgl_pinjam_usage_room', 'jam_mulai_usage_room', 'jam_selesai_usage_room')
    //     //     ->where('kode_peminjaman', $kode_peminjaman)
    //     //     ->orderBy('tgl_pinjam_usage_room')
    //     //     ->get();

    //     // $resultdataUsageRoom = $dataUsageRoom->mapToGroups(function ($item) {
    //     //     // Kita gunakan tanggal sebagai KEY group
    //     //     return [
    //     //         $item->tgl_pinjam_usage_room => [
    //     //             'jam_mulai' => $item->jam_mulai_usage_room,
    //     //             'jam_selesai' => $item->jam_selesai_usage_room
    //     //         ]
    //     //     ];
    //     // })->map(function ($group) {
    //     //     // Menghapus duplikat data jam yang sama persis di tanggal tersebut
    //     //     return $group->unique(function ($jam) {
    //     //         return $jam['jam_mulai'] . $jam['jam_selesai'];
    //     //     })->values();
    //     // })->toArray();

    //     // $dataUsageItem = DB::table('usage_items')
    //     //     ->select('tgl_pinjam_usage_item', 'jam_mulai_usage_item', 'jam_selesai_usage_item')
    //     //     ->where('kode_peminjaman', $kode_peminjaman)
    //     //     ->orderBy('tgl_pinjam_usage_item')
    //     //     ->get();

    //     // $resultdataUsageItem = $dataUsageItem->mapToGroups(function ($item) {
    //     //     // Kita gunakan tanggal sebagai KEY group
    //     //     return [
    //     //         $item->tgl_pinjam_usage_item => [
    //     //             'jam_mulai' => $item->jam_mulai_usage_item,
    //     //             'jam_selesai' => $item->jam_selesai_usage_item
    //     //         ]
    //     //     ];
    //     // })->map(function ($group) {
    //     //     // Menghapus duplikat data jam yang sama persis di tanggal tersebut
    //     //     return $group->unique(function ($jam) {
    //     //         return $jam['jam_mulai'] . $jam['jam_selesai'];
    //     //     })->values();
    //     // })->toArray();
    //     // // dd($dataUsageRoom, $dataUsageItem);

    //     // // 2. Proses data untuk mendapatkan format yang diinginkan
    //     // $tglJamPinjam = null;
    //     // if ($dataUsageRoom->empty()) {
    //     //     $tglJamPinjam = $resultdataUsageItem;
    //     // } else {
    //     //     $tglJamPinjam = $resultdataUsageRoom;
    //     // }

    //     // dd($tglJamPinjam);

    //     // 1. Ambil data mentah dari database
    //     $dataUsageRoom = DB::table('usage_rooms')
    //         ->where('kode_peminjaman', $kode_peminjaman)
    //         ->get();

    //     $dataUsageItem = DB::table('usage_items')
    //         ->where('kode_peminjaman', $kode_peminjaman)
    //         ->get();

    //     // 2. Samakan format kolom Room dan masukkan ke array baru
    //     $roomMapped = $dataUsageRoom->map(function ($item) {
    //         return (object) [
    //             'tgl_pinjam_usage'   => date('Y-m-d', strtotime($item->tgl_pinjam_usage_room)),
    //             'tgl_kembali_usage'  => date('Y-m-d', strtotime($item->tgl_pinjam_usage_room)),
    //             'jam_mulai_usage'    => $item->jam_mulai_usage_room,
    //             'jam_selesai_usage'  => $item->jam_selesai_usage_room,
    //             'status_usage'       => $item->status_usage_room, // Disamakan
    //         ];
    //     });

    //     // 3. Samakan format kolom Item dan masukkan ke array baru
    //     $itemMapped = $dataUsageItem->map(function ($item) {
    //         return (object) [
    //             'tgl_pinjam_usage'   => date('Y-m-d', strtotime($item->tgl_pinjam_usage_item)),
    //             'tgl_kembali_usage'  => date('Y-m-d', strtotime($item->tgl_pinjam_usage_item)),
    //             'jam_mulai_usage'    => $item->jam_mulai_usage_item,
    //             'jam_selesai_usage'  => $item->jam_selesai_usage_item,
    //             'status_usage'       => $item->status_usage_item, // Disamakan
    //         ];
    //     });

    //     // 4. Gabungkan Room & Item, lalu kelompokkan HANYA berdasarkan tanggal unik
    //     $semuaRiwayatTergabung = $roomMapped->concat($itemMapped)
    //         ->groupBy(function ($item) {
    //             // Kelompokkan berdasarkan tanggal (Y-m-d)
    //             return date('Y-m-d', strtotime($item->tgl_pinjam_usage));
    //         })
    //         ->map(function ($group) {
    //             // Ambil data yang berstatus 'terjadwal' terlebih dahulu agar data aktif tidak hilang
    //             return $group->where('status_usage', 'terjadwal')->first() ?? $group->first();
    //         })
    //         ->values(); // Reset indeks array agar urut dari 0, 1, 2...

    //     // dd($semuaRiwayatTergabung);
    //     // Sekarang Anda hanya punya SATU variabel untuk dilempar ke View
    //     // return view('nama_view', compact('semuaRiwayatTergabung'));d

    //     $Pengambilan = $semuaRiwayatTergabung->where('status_usage','terjadwal')->first();
    //     $Pengembalian = $semuaRiwayatTergabung->where('status_usage','digunakan')->first();
    //     // dd($semuaRiwayatTergabung, $Pengambilan, $Pengembalian);

    //     if ($aksi === 'QR') {
    //         // return ke halaman qr code
    //         return view('components.mahasiswa.contentQRcode', compact('kode_peminjaman', 'status_peminjaman', 'Pengambilan', 'Pengembalian'));
    //     } else {
    //         // update status jika dibatalkan user
    //         DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
    //             ->update([
    //                 'status_peminjaman' => 'dibatalkan',
    //                 'updated_at' => now(),
    //             ]);

    //         UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
    //             ->update([
    //                 'status_usage_item' => 'dibatalkan',
    //                 'updated_at' => now(),
    //             ]);

    //         UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
    //             ->update([
    //                 'status_usage_room' => 'dibatalkan',
    //                 'updated_at' => now(),
    //             ]);

    //         return back()->with('success', 'transaksi ' . $kode_peminjaman . ' dibatalkan');
    //     }

    //     // dd($kode_peminjaman);

    // }

    // public function QrDanBatalPeminjaman(Request $request)
    // {
    //     $kode_peminjaman = $request->input('kode_peminjaman');
    //     $status_peminjaman = $request->input('status_peminjaman');
    //     $aksi = $request->input('aksi');

    //     $dataUsageRoom = DB::table('usage_rooms')->where('kode_peminjaman', $kode_peminjaman)->get();
    //     $dataUsageItem = DB::table('usage_items')->where('kode_peminjaman', $kode_peminjaman)->get();

    //     $roomMapped = $dataUsageRoom->map(function ($item) {
    //         return (object) [
    //             'tgl_pinjam_usage'   => date('Y-m-d', strtotime($item->tgl_pinjam_usage_room)),
    //             'jam_mulai_usage'    => $item->jam_mulai_usage_room,
    //             'jam_selesai_usage'  => $item->jam_selesai_usage_room,
    //             'status_usage'       => $item->status_usage_room,
    //         ];
    //     });

    //     $itemMapped = $dataUsageItem->map(function ($item) {
    //         return (object) [
    //             'tgl_pinjam_usage'   => date('Y-m-d', strtotime($item->tgl_pinjam_usage_item)),
    //             'jam_mulai_usage'    => $item->jam_mulai_usage_item,
    //             'jam_selesai_usage'  => $item->jam_selesai_usage_item,
    //             'status_usage'       => $item->status_usage_item,
    //         ];
    //     });

    //     $semuaRiwayatTergabung = $roomMapped->concat($itemMapped)
    //         ->groupBy(function ($item) {
    //             return date('Y-m-d', strtotime($item->tgl_pinjam_usage));
    //         })
    //         ->map(function ($group) {
    //             // Ambil yang terjadwal dulu, jika tidak ada baru ambil status lain (dipinjam/digunakan)
    //             return $group->where('status_usage', 'terjadwal')->first() ?? $group->first();
    //         })
    //         ->values();

    //     // Mencegah error 'Attempt to read property on null' di Blade menggunakan optional object data
    //     $Pengambilan = $semuaRiwayatTergabung->where('status_usage', 'terjadwal')->first()
    //         ?? $semuaRiwayatTergabung->first()
    //         ?? (object)['status_usage' => 'tidak berlaku', 'tgl_pinjam_usage' => now()->toDateString(), 'jam_mulai_usage' => null, 'jam_selesai_usage' => null];

    //     $Pengembalian = $semuaRiwayatTergabung->whereIn('status_usage', ['dipinjam', 'digunakan'])->first()
    //         ?? $semuaRiwayatTergabung->first()
    //         ?? (object)['status_usage' => 'tidak berlaku', 'tgl_pinjam_usage' => now()->toDateString(), 'jam_mulai_usage' => null, 'jam_selesai_usage' => null];

    //     if ($aksi === 'QR') {
    //         return view('components.mahasiswa.contentQRcode', compact('kode_peminjaman', 'status_peminjaman', 'Pengambilan', 'Pengembalian'));
    //     } else {
    //         // ... (Logika pembatalan Anda tetap sama)
    //         DB::table('peminjaman')->where('kode_peminjaman', $kode_peminjaman)->update(['status_peminjaman' => 'dibatalkan', 'updated_at' => now()]);
    //         DB::table('usage_items')->where('kode_peminjaman', $kode_peminjaman)->update(['status_usage_item' => 'dibatalkan', 'updated_at' => now()]);
    //         DB::table('usage_rooms')->where('kode_peminjaman', $kode_peminjaman)->update(['status_usage_room' => 'dibatalkan', 'updated_at' => now()]);

    //         return back()->with('success', 'transaksi ' . $kode_peminjaman . ' dibatalkan');
    //     }
    // }


    public function QrDanBatalPeminjaman(Request $request)
    {
        $kode_peminjaman = $request->input('kode_peminjaman');
        $status_peminjaman = $request->input('status_peminjaman');
        $aksi = $request->input('aksi');

        // 1. Ambil data mentah dari database
        $dataUsageRoom = DB::table('usage_rooms')
            ->where('kode_peminjaman', $kode_peminjaman)
            ->get();

        $dataUsageItem = DB::table('usage_items')
            ->where('kode_peminjaman', $kode_peminjaman)
            ->get();

        // 2. Samakan format kolom Room dan masukkan ke array baru
        $roomMapped = $dataUsageRoom->map(function ($item) {
            return (object) [
                'tgl_pinjam_usage'   => date('Y-m-d', strtotime($item->tgl_pinjam_usage_room)),
                'jam_mulai_usage'    => $item->jam_mulai_usage_room,
                'jam_selesai_usage'  => $item->jam_selesai_usage_room,
                'status_usage'       => $item->status_usage_room,
            ];
        });

        // 3. Samakan format kolom Item dan masukkan ke array baru
        $itemMapped = $dataUsageItem->map(function ($item) {
            return (object) [
                'tgl_pinjam_usage'   => date('Y-m-d', strtotime($item->tgl_pinjam_usage_item)),
                'jam_mulai_usage'    => $item->jam_mulai_usage_item,
                'jam_selesai_usage'  => $item->jam_selesai_usage_item,
                'status_usage'       => $item->status_usage_item,
            ];
        });

        // 4. Gabungkan Room & Item, lalu kelompokkan berdasarkan tanggal unik
        $semuaRiwayatTergabung = $roomMapped->concat($itemMapped)
            ->groupBy(function ($item) {
                return date('Y-m-d', strtotime($item->tgl_pinjam_usage));
            })
            ->map(function ($group) {
                // Ambil data yang berstatus 'terjadwal' terlebih dahulu agar data aktif tidak hilang
                return $group->where('status_usage', 'terjadwal')->first() ?? $group->first();
            })
            ->values();

        // 5. Mencegah error 'Attempt to read property on null' dengan objek fallback kosong yang aman
        $Pengambilan = $semuaRiwayatTergabung->where('status_usage', 'terjadwal')->first()
            ?? $semuaRiwayatTergabung->first()
            ?? (object)['status_usage' => 'tidak berlaku', 'tgl_pinjam_usage' => now()->toDateString(), 'jam_mulai_usage' => null, 'jam_selesai_usage' => null];

        $Pengembalian = $semuaRiwayatTergabung->whereIn('status_usage', ['dipinjam', 'digunakan'])->first()
            ?? $semuaRiwayatTergabung->first()
            ?? (object)['status_usage' => 'tidak berlaku', 'tgl_pinjam_usage' => now()->toDateString(), 'jam_mulai_usage' => null, 'jam_selesai_usage' => null];

        if ($aksi === 'QR') {
            // Return ke halaman QR Code dengan membawa collection lengkap
            return view('components.mahasiswa.contentQRcode', compact('kode_peminjaman', 'status_peminjaman', 'Pengambilan', 'Pengembalian', 'semuaRiwayatTergabung'));
        } else {
            // Update status jika dibatalkan oleh user
            DB::table('peminjaman')->where('kode_peminjaman', $kode_peminjaman)
                ->update([
                    'status_peminjaman' => 'dibatalkan',
                    'updated_at' => now(),
                ]);

            UsageItems::where('kode_peminjaman', $kode_peminjaman)
                ->update([
                    'status_usage_item' => 'dibatalkan',
                    'updated_at' => now(),
                ]);

            UsageRooms::where('kode_peminjaman', $kode_peminjaman)
                ->update([
                    'status_usage_room' => 'dibatalkan',
                    'updated_at' => now(),
                ]);

            return back()->with('success', 'Transaksi ' . $kode_peminjaman . ' berhasil dibatalkan');
        }
    }
}
