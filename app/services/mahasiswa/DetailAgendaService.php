<?php

namespace App\Services\mahasiswa;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DetailAgendaService
{
    // mengambil data jadwal penggunaan barang atau ruangan
    public function dataPenggunaanBarangDanRuang($id, $date)
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
                ->where('usage_items.tgl_pinjam_usage_item', $date)
                ->get();

            $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
                ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
                ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
                ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
                ->where('usage_rooms.kode_peminjaman', $id)
                ->where('usage_rooms.tgl_pinjam_usage_room', $date)
                ->get();

            // hasil data peminjaman termasuk penggunaan barang dan ruang
            return [
                // 'agenda_fakultas' => $dataDetailAgenda,
                'header' => $dataDetailPengajuanPeminjaman,
                'usage_barang' => $dataDetailPengajuanPeminjamanBarang,
                'usage_ruang' => $dataDetailPengajuanPeminjamanRuangan,
                'tgl_pinjam' => $date,
            ];

        } else {

            $dataDetailPengajuanPeminjamanBarang = DB::table('usage_items')
                ->join('items', 'usage_items.id_item', '=', 'items.id_item')
                ->select('usage_items.*', 'items.nama_item', 'items.id_item', 'items.kondisi_item', 'items.img_item') // Pilih kolom yang diperlukan
                ->where('usage_items.kode_agenda', $id)
                // ->where('usage_items.tgl_pinjam_usage_item', $date)
                ->whereDate('usage_items.tgl_pinjam_usage_item', $date)
                ->get();

            $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
                ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
                ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
                ->select('usage_rooms.*', 'rooms.nama_room', 'rooms.id_room', 'rooms.kondisi_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
                ->where('usage_rooms.kode_agenda', $id)
                // ->where('usage_rooms.tgl_pinjam_usage_room', $date)
                ->whereDate('usage_rooms.tgl_pinjam_usage_room', $date)
                ->get();

            // Tandai usage yang masih boleh dibatalkan oleh admin.
            // Jadwal selesai/dibatalkan maupun jadwal yang waktunya sudah lewat tidak diberi aksi batal.
            $sekarang = Carbon::now();
            $cekDapatDibatalkan = function ($usage, string $jenis) use ($sekarang) {
                $status = $jenis === 'barang' ? $usage->status_usage_item : $usage->status_usage_room;
                $tanggal = $jenis === 'barang' ? $usage->tgl_pinjam_usage_item : $usage->tgl_pinjam_usage_room;
                $jamSelesai = $jenis === 'barang' ? $usage->jam_selesai_usage_item : $usage->jam_selesai_usage_room;

                if (!in_array($status, ['terjadwal', 'digunakan'], true)) {
                    return false;
                }

                $tanggalUsage = Carbon::parse($tanggal)->startOfDay();
                if ($tanggalUsage->gt($sekarang->copy()->startOfDay())) {
                    return true;
                }

                if (!$tanggalUsage->isSameDay($sekarang)) {
                    return false;
                }

                if ($jamSelesai === null) {
                    return true;
                }

                return Carbon::parse($tanggalUsage->format('Y-m-d') . ' ' . $jamSelesai)->gt($sekarang);
            };

            $dataDetailPengajuanPeminjamanBarang->each(function ($usage) use ($cekDapatDibatalkan) {
                $usage->dapat_dibatalkan = $cekDapatDibatalkan($usage, 'barang');
            });

            $dataDetailPengajuanPeminjamanRuangan->each(function ($usage) use ($cekDapatDibatalkan) {
                $usage->dapat_dibatalkan = $cekDapatDibatalkan($usage, 'ruangan');
            });

            // hasil data agenda termasuk penggunaan barang dan ruang
            return [
                'header' => $dataDetailAgenda,
                'usage_barang' => $dataDetailPengajuanPeminjamanBarang,
                'usage_ruang' => $dataDetailPengajuanPeminjamanRuangan,
                'tgl_pinjam' => $date
            ];
        }
    }
}
