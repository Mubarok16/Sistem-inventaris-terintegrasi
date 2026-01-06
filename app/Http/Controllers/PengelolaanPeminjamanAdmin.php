<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\UsageItems;
use App\Models\UsageRooms;
use App\Services\Admin\PengelolaanPeminjamanService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengelolaanPeminjamanAdmin extends Controller
{
    // menampilkan halaman detail peminjaman admin
    function DetailPeminjamanAdmin($id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $dataDetailPengajuanPeminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->select('peminjaman.*', 'peminjam.nama_peminjam', 'peminjam.no_identitas', 'peminjam.fakultas', 'peminjam.prodi') // Pilih kolom yang diperlukan
            ->where('peminjaman.kode_peminjaman', $id)
            ->get();

        $dataDetailPengajuanPeminjamanBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select('usage_items.*', 'items.nama_item', 'items.id_item', 'items.kondisi_item', 'items.img_item') // Pilih kolom yang diperlukan
            ->where('usage_items.kode_peminjaman', $id)
            ->get();

        $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_peminjaman', $id)
            ->get();

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

        if ($tglPinjamItem) {
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

        // dd($itemBentrok, $roomBentrok);

        $user = Auth::user()->nama;
        $halaman = 'contentDetailPenminjaman';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataDetailPengajuanPeminjaman', 'dataDetailPengajuanPeminjamanBarang', 'dataDetailPengajuanPeminjamanRuangan', 'tglPinjam', 'tglKembali', 'itemBentrok', 'roomBentrok'));
    }

    // persetujuan
    function persetujuan(Request $request)
    {
        $request->validate([
            'kode_peminjaman' => 'string',
        ]);

        // id admin yg approve
        $id_admin = Auth::user()->id_user;
        // dd($request->all());

        if ($request->aksi === 'approve') {
            // update status jika disetujui
            DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_peminjaman' => 'terjadwal',
                    'updated_at' => now(),
                    'id_user' => $id_admin,
                    'catatan_pengelola' => $request->catatan
                ]);

            UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_item' => 'terjadwal',
                    'updated_at' => now(),
                ]);

            UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_room' => 'terjadwal',
                    'updated_at' => now(),
                ]);

            return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'Status persetujuan berhasil diperbarui.');
        } else {
            // update status jika di reject
            DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_peminjaman' => 'ditolak',
                    'updated_at' => now(),
                    'id_user' => $id_admin,
                    'catatan_pengelola' => $request->catatan
                ]);

            UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_item' => 'ditolak',
                    'updated_at' => now(),
                ]);

            UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
                ->update([
                    'status_usage_room' => 'ditolak',
                    'updated_at' => now(),
                ]);

            return redirect()->route('admin.pengajuan.peminjaman')->with('gagal', 'Status persetujuan berhasil diperbarui.');
        }
    }

    // // persetujuan
    // function penolakan(Request $request)
    // {
    //     $request->validate([
    //         'kode_peminjaman' => 'string',
    //     ]);

    //     // id admin yg approve
    //     $id_admin = Auth::user()->id_user;

    //     DB::table('peminjaman')->where('kode_peminjaman', $request->kode_peminjaman)
    //         ->update([
    //             'status_peminjaman' => 'terjadwal',
    //             'updated_at' => now(),
    //             'id_user' => $id_admin,
    //             'catatan_pengelola' => $request->catatan
    //         ]);

    //     UsageItems::where('kode_peminjaman', $request->kode_peminjaman)
    //         ->update([
    //             'status_usage_item' => 'terjadwal',
    //             'updated_at' => now(),
    //         ]);

    //     UsageRooms::where('kode_peminjaman', $request->kode_peminjaman)
    //         ->update([
    //             'status_usage_room' => 'terjadwal',
    //             'updated_at' => now(),
    //         ]);

    //     return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'Status persetujuan berhasil diperbarui.');
    // }

    function pilihDataPengajuanPeminjamanAdmin(Request $request)
    {
        // Mengambil nilai dari tombol yang diklik
        $status = $request->input('status');

        // Menyimpan data ke session
        $request->session()->put('status-peminjaman', $status);

        return back();
    }
}
