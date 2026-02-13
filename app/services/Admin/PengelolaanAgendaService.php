<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

class PengelolaanAgendaService
{

    public function dataDetailAgenda($kode)
    {
        // Your code logic here
        // 1. Ambil data dasar
        $peminjaman = DB::table('agenda_fakultas')->where('kode_agenda', $kode)->first();
        if (!$peminjaman) return response()->json(['message' => 'Data tidak ditemukan'], 404);

        // 2. Query Rooms
        $rooms = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->where('usage_rooms.kode_agenda', $kode)
            ->select(
                'rooms.nama_room', // Samakan nama kolom dengan item agar konsisten
                'tipe_rooms.nama_tipe_room',
                DB::raw('DATE(usage_rooms.tgl_pinjam_usage_room) as tanggal'),
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'usage_rooms.status_usage_room',
                'rooms.kondisi_room',
                'rooms.gambar_room'
            )
            ->get();

        // 3. Query Items
        $items = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->where('usage_items.kode_agenda', $kode)
            ->select(
                'items.nama_item',
                'tipe_item.nama_tipe_item',
                DB::raw('DATE(usage_items.tgl_pinjam_usage_item) as tanggal'),
                'usage_items.jam_mulai_usage_item',
                'usage_items.jam_selesai_usage_item',
                'usage_items.status_usage_item',
                'usage_items.qty_usage_item',
                'items.kondisi_item',
                'items.img_item'
            )
            ->get();

        // Gabungkan
        // $perhari = $rooms->concat($items)->groupBy('tanggal')->toArray();

        // 4. Proses Penggabungan dan Pemetaan Ulang
        $perhari = $rooms->concat($items)
            ->groupBy('tanggal')
            ->map(function ($itemsInDate, $tanggal) {
                // Ambil salah satu item untuk data umum (tanggal, status, kondisi, jam)
                $first = $itemsInDate->first();

                // Bentuk struktur baru
                return [
                    "tanggal" => $tanggal,
                    // Kita gunakan null coalescing untuk jam, status, dan kondisi agar tetap muncul meski dari room atau item
                    "jam_mulai"   => $first->jam_mulai_usage_room ?? $first->jam_mulai_usage_item ?? null,
                    "jam_selesai" => $first->jam_selesai_usage_room ?? $first->jam_selesai_usage_item ?? null,
                    "status"      => $first->status_usage_room ?? $first->status_usage_item ?? null,
                    "kondisi"     => $first->kondisi_room ?? $first->kondisi_item ?? null,

                    // Bagian ini mengumpulkan semua nama barang/ruangan ke satu array
                    "barang_ruang" => $itemsInDate->map(function ($item) {
                        if (isset($item->nama_room)) {
                            return [
                                "nama_room" => $item->nama_room,
                                "nama_tipe_room" => $item->nama_tipe_room,
                                "gambar_room" => $item->gambar_room
                            ];
                        } else {
                            return [
                                "nama_item" => $item->nama_item,
                                "nama_tipe_item" => $item->nama_tipe_item,
                                "qty" => $item->qty_usage_item,
                                "img_item" => $item->img_item
                            ];
                        }
                    })->values()->toArray()
                ];
            })->toArray();

        // Return dalam satu bungkus array

        return $perhari;
    }

    public function getBarangDanRaung()
    {
        $items = DB::table('items')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->select(
                'items.id_item as id',
                'items.nama_item',
                'items.kondisi_item',
                'items.img_item',
                'items.qty_item',
                'tipe_item.nama_tipe_item'
            )
            ->get()
            ->map(function ($item) {
                $item->category = 'barang'; // Tambah properti kategori
                return $item;
            });

        $rooms = DB::table('rooms')
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select(
                'rooms.id_room as id',
                'rooms.nama_room as nama_item',
                'rooms.kondisi_room as kondisi_item',
                'rooms.gambar_room as img_item',
                'tipe_rooms.nama_tipe_room as nama_tipe_item'
            )
            ->get()
            ->map(function ($room) {
                $room->category = 'ruangan'; // Tambah properti kategori
                return $room;
            });

        $allBarangRuang = $items->merge($rooms)->map(function ($item) {
            // Kita bersihkan img_item dari backslash yang merusak JS
            if (isset($item->img_item)) {
                $item->img_item = str_replace('\\', '/', $item->img_item);
            }
            return $item;
        });

        return $allBarangRuang;
    }
}
