<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
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
        // $PengelolaanPeminjamanService = new PengelolaanPeminjamanService;
        // $dataBentrokJadwal = $PengelolaanPeminjamanService->cekPeminjamanAgenda($id, $tglPinjam, $tglKembali);

        // // mengambil data barang yg bentrok return dari service cek jadwal
        // $itemBentrok = $dataBentrokJadwal['barang']->filter(function ($item) {
        //     return $item['status'] === 'BENTROK';
        // });

        // // mengambil data ruangan yg bentrok return dari service cek jadwal
        // $roomBentrok = $dataBentrokJadwal['ruangan']->filter(function ($room) {
        //     return $room['status'] === 'BENTROK';
        // });

        // dd($itemBentrok, $roomBentrok);
        
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentRiwayatDetail';
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'dataDetailPengajuanPeminjaman', 'dataDetailPengajuanPeminjamanBarang', 'dataDetailPengajuanPeminjamanRuangan', 'tglPinjam', 'tglKembali'));
    }
}
