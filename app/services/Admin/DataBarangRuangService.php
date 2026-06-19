<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

class DataBarangRuangService
{
    public function getBarangDanRaung($lingkup)
    {
        $items = DB::table('items')
            ->leftJoin('rooms', 'items.id_room', '=', 'rooms.id_room')
            ->select(
                'items.id_item as id',
                'items.nama_item',
                'items.merek_model',
                'items.kondisi_item',
                'items.img_item',
                'items.qty_item',
                'rooms.nama_room',
                'items.id_room',
                'items.kepemilikan_pengelolaan'
            )
            ->where('items.kepemilikan_pengelolaan', $lingkup)
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
                'tipe_rooms.nama_tipe_room as nama_tipe_item',
                'rooms.kepemilikan_pengelolaan'
            )
            ->where('rooms.kepemilikan_pengelolaan', $lingkup)
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