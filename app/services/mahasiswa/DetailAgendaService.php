<?php

namespace App\Services\mahasiswa;

use Illuminate\Support\Facades\DB;

class DetailAgendaService
{
    // mengambil data jadwal penggunaan barang atau ruangan
    public function dataPenggunaanBarangDanRuang($id)
    {
        $dataDetailAgenda = DB::table('agenda_fakultas')
            // ->select('peminjaman.*', 'peminjam.nama_peminjam', 'peminjam.no_identitas', 'peminjam.fakultas', 'peminjam.prodi') // Pilih kolom yang diperlukan
            ->where('kode_agenda', $id)
            ->get();

        $dataDetailPengajuanPeminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->select('peminjaman.*', 'peminjam.nama_peminjam', 'peminjam.no_identitas', 'peminjam.fakultas', 'peminjam.prodi') // Pilih kolom yang diperlukan
            ->where('peminjaman.kode_peminjaman', $id)
            ->get();

        if ($dataDetailAgenda->isEmpty()) {
            // hasil data peminjaman
            $dataDetailPengajuanPeminjamanBarang = DB::table('usage_items')
                ->join('items', 'usage_items.id_item', '=', 'items.id_item')
                ->select('usage_items.*', 'items.nama_item', 'items.id_item', 'items.kondisi_item', 'items.img_item') // Pilih kolom yang diperlukan
                ->where('usage_items.kode_peminjaman', $id)
                ->first();

            $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
                ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
                ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
                ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
                ->where('usage_rooms.kode_peminjaman', $id)
                ->first();

            // mengambil tgl pinjam dan tgl kembali dari usage_items dan usage_rooms
            $tglPinjamItem = DB::table('usage_items')
                ->select('tgl_pinjam_usage_item', 'tgl_kembali_usage_item')
                ->where('kode_peminjaman', $id)
                ->first();

            $tglPinjamRoom = DB::table('usage_rooms')
                ->select('tgl_pinjam_usage_room', 'tgl_kembali_usage_room')
                ->where('kode_peminjaman', $id)
                ->first();

            $tglPinjam = null;
            $tglKembali = null;

            if ($tglPinjamItem) {
                $tglPinjam = $tglPinjamItem->tgl_pinjam_usage_item;
                $tglKembali = $tglPinjamItem->tgl_kembali_usage_item;
            } else {
                $tglPinjam = $tglPinjamRoom->tgl_pinjam_usage_room;
                $tglKembali = $tglPinjamRoom->tgl_kembali_usage_room;
            }

            // dd($tglKembali);

            // hasil data peminjaman
            return [
                // 'agenda_fakultas' => $dataDetailAgenda,
                'header' => $dataDetailPengajuanPeminjaman,
                'usage_barang' => $dataDetailPengajuanPeminjamanBarang,
                'usage_ruang' => $dataDetailPengajuanPeminjamanRuangan,
                'tgl_pinjam' => $tglPinjam,
                'tgl_kembali' => $tglKembali,
            ];
        } else {

            $dataDetailPengajuanPeminjamanBarang = DB::table('usage_items')
                ->join('items', 'usage_items.id_item', '=', 'items.id_item')
                ->select('usage_items.*', 'items.nama_item', 'items.id_item', 'items.kondisi_item', 'items.img_item') // Pilih kolom yang diperlukan
                ->where('usage_items.kode_agenda', $id)
                ->first();

            $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
                ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
                ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
                ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
                ->where('usage_rooms.kode_agenda', $id)
                ->first();

            // mengambil tgl pinjam dan tgl kembali dari usage_items dan usage_rooms
            $tglPinjamItem = DB::table('usage_items')
                ->select('tgl_pinjam_usage_item', 'tgl_kembali_usage_item')
                ->where('kode_agenda', $id)
                ->first();

            $tglPinjamRoom = DB::table('usage_rooms')
                ->select('tgl_pinjam_usage_room', 'tgl_kembali_usage_room')
                ->where('kode_agenda', $id)
                ->first();

            $tglPinjam = null;
            $tglKembali = null;

            // mengambil data tgl mulai dan tgl selesai dari agenda fakultas
            foreach ($dataDetailAgenda as $tgl) {
                $tglPinjam = $tgl->tgl_mulai_agenda;
                $tglKembali = $tgl->tgl_selesai_agenda;
            }


            // if ($tglPinjamItem) {
            //     // foreach ($tglPinjamItem as $value) {
            //     $tglPinjam = $tglPinjamItem->tgl_pinjam_usage_item;
            //     $tglKembali = $tglPinjamItem->tgl_kembali_usage_item;
            //     // }
            // } else {
            //     // foreach ($tglPinjamRoom as $value) {
            //     $tglPinjam = $tglPinjamRoom->tgl_pinjam_usage_room;
            //     $tglKembali = $tglPinjamRoom->tgl_kembali_usage_room;
            //     // }
            // }

            // hasil data agenda termasuk penggunaan barang dan ruang
            return [
                'header' => $dataDetailAgenda,
                // 'Peminjaman' => $dataDetailPengajuanPeminjaman,
                'usage_barang' => $dataDetailPengajuanPeminjamanBarang,
                'usage_ruang' => $dataDetailPengajuanPeminjamanRuangan,
                'tgl_pinjam' => $tglPinjam,
                'tgl_kembali' => $tglKembali,
            ];
        }
    }
}
