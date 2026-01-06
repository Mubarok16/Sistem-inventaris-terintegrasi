<?php

namespace App\Services\Admin;

use App\Models\DataBarang;
use App\Models\Peminjaman;
use App\Models\UsageItems;
use App\Models\UsageRooms;
use Illuminate\Support\Facades\DB;

class PengelolaanPeminjamanService
{
    // mengambil data jadwal penggunaan barang atau ruangan berdasarkan status
    public function dataPenggunaanBarangByStatus($status)
    {
        $dataPengajuanPeminjaman = Peminjaman::join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->leftJoin('usage_items', 'usage_items.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->leftJoin('usage_rooms', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->selectRaw('DISTINCT ON (peminjaman.kode_peminjaman) 
                peminjaman.*, 
                peminjam.nama_peminjam, 
                usage_items.tgl_pinjam_usage_item, 
                usage_items.tgl_kembali_usage_item, 
                usage_rooms.tgl_pinjam_usage_room, 
                usage_rooms.tgl_kembali_usage_room, 
                usage_rooms.jam_mulai_usage_room, 
                usage_rooms.jam_selesai_usage_room, 
                usage_items.jam_mulai_usage_item, 
                usage_items.jam_selesai_usage_item')

            ->when($status !== 'semua', function ($query) use ($status) {
                return $query->where('peminjaman.status_peminjaman', $status);
            })
            // ->where('peminjaman.status_peminjaman', $status)
            ->orderBy('peminjaman.kode_peminjaman') // Mengelompokkan berdasarkan kode unik
            ->orderBy('peminjaman.created_at', 'asc')
            ->get();

        return $dataPengajuanPeminjaman;
    }

    // cek bentrok agenda
    public function cekPeminjamanAgenda($kode, $tglPinjam, $tglKembali)
    {
        $usageItems = DB::table('usage_items as ui')
            ->join('items as i', 'i.id_item', '=', 'ui.id_item')
            ->where('ui.kode_peminjaman', $kode)
            ->select(
                'ui.*',
                'i.nama_item',
                'i.qty_item'
            )
            ->get();

        $hasilItem = $usageItems->map(function ($item) use ($kode) {

            $transaksiBentrok = DB::table('usage_items')
                ->leftJoin('agenda_fakultas', 'usage_items.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
                ->leftJoin('peminjaman', 'usage_items.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
                ->leftJoin('items', 'usage_items.id_item', '=', 'items.id_item')
                ->where('usage_items.id_item', $item->id_item)
                ->where('usage_items.status_usage_item', '!=', 'selesai')
                ->where('usage_items.status_usage_item', '!=', 'diajukan')
                ->where('usage_items.status_usage_item', '!=', 'ditolak')

                // abaikan milik peminjaman ini
                ->where(function ($q) use ($kode) {
                    $q->whereNull('usage_items.kode_peminjaman')
                        ->orWhere('usage_items.kode_peminjaman', '!=', $kode);
                })

                // ================================
                // OVERLAP TANGGAL + JAM
                // ================================
                ->where(function ($q) use ($item) {

                    // 1️⃣ OVERLAP TANGGAL
                    $q->where(function ($x) use ($item) {
                        $x->whereDate('usage_items.tgl_kembali_usage_item', '<=', $item->tgl_kembali_usage_item)
                            ->whereDate('usage_items.tgl_pinjam_usage_item', '>=', $item->tgl_pinjam_usage_item);
                    })

                        // 2️⃣ OVERLAP JAM
                        ->where(function ($x) use ($item) {

                            // KASUS A: existing FULL DAY
                            $x->where(function ($y) {
                                $y->whereNull('usage_items.jam_mulai_usage_item')
                                    ->whereNull('usage_items.jam_selesai_usage_item');
                            })

                                // KASUS B: request FULL DAY
                                ->orWhere(function ($y) use ($item) {
                                    if ($item->jam_mulai_usage_item === null && $item->jam_selesai_usage_item === null) {
                                        $y->whereRaw('1 = 1'); // selalu bentrok
                                        // $y->whereNull('jam_mulai_usage_item')
                                        //     ->whereNull('jam_selesai_usage_item')
                                        //     ->where('jam_selesai_usage_item', '<', '23:59:00')
                                        //     ->where('jam_mulai_usage_item', '>', '00:00:00');
                                    }
                                })

                                // KASUS C: SAMA-SAMA PAKAI JAM
                                ->orWhere(function ($y) use ($item) {
                                    if ($item->jam_mulai_usage_item !== null && $item->jam_selesai_usage_item !== null) {
                                        $y->whereNotNull('usage_items.jam_mulai_usage_item')
                                            ->whereNotNull('usage_items.jam_selesai_usage_item')
                                            ->where('usage_items.jam_selesai_usage_item', '<', $item->jam_selesai_usage_item)
                                            ->where('usage_items.jam_mulai_usage_item', '>', $item->jam_mulai_usage_item);
                                    }
                                });
                        });
                })
                ->get()
                ->first();

            $bentrok = (int) DB::table('usage_items')
                ->where('id_item', $item->id_item)
                ->where('status_usage_item', '!=', 'selesai')
                ->where('status_usage_item', '!=', 'diajukan')
                ->where('status_usage_item', '!=', 'ditolak')

                // abaikan milik peminjaman ini
                ->where(function ($q) use ($kode) {
                    $q->whereNull('kode_peminjaman')
                        ->orWhere('kode_peminjaman', '!=', $kode);
                })

                // ================================
                // OVERLAP TANGGAL + JAM
                // ================================
                ->where(function ($q) use ($item) {

                    // 1️⃣ OVERLAP TANGGAL
                    $q->where(function ($x) use ($item) {
                        $x->whereDate('tgl_kembali_usage_item', '<=', $item->tgl_kembali_usage_item)
                            ->whereDate('tgl_pinjam_usage_item', '>=', $item->tgl_pinjam_usage_item);
                    })

                        // 2️⃣ OVERLAP JAM
                        ->where(function ($x) use ($item) {

                            // KASUS A: existing FULL DAY
                            $x->where(function ($y) {
                                $y->whereNull('jam_mulai_usage_item')
                                    ->whereNull('jam_selesai_usage_item');
                            })

                                // KASUS B: request FULL DAY
                                ->orWhere(function ($y) use ($item) {
                                    if ($item->jam_mulai_usage_item === null && $item->jam_selesai_usage_item === null) {
                                        $y->whereRaw('1 = 1'); // selalu bentrok
                                        // $y->whereNull('jam_mulai_usage_item')
                                        //     ->whereNull('jam_selesai_usage_item')
                                        //     ->where('jam_selesai_usage_item', '<', '23:59:00')
                                        //     ->where('jam_mulai_usage_item', '>', '00:00:00');
                                    }
                                })

                                // KASUS C: SAMA-SAMA PAKAI JAM
                                ->orWhere(function ($y) use ($item) {
                                    if ($item->jam_mulai_usage_item !== null && $item->jam_selesai_usage_item !== null) {
                                        $y->whereNotNull('jam_mulai_usage_item')
                                            ->whereNotNull('jam_selesai_usage_item')
                                            ->where('jam_selesai_usage_item', '<', $item->jam_selesai_usage_item)
                                            ->where('jam_mulai_usage_item', '>', $item->jam_mulai_usage_item);
                                    }
                                });
                        });
                })
                // ->get();
                ->sum('qty_usage_item');

            return [
                'kode_peminjaman_bentrok' => $transaksiBentrok === null ? null : $transaksiBentrok->kode_peminjaman,
                'kode_agenda_bentrok' => $transaksiBentrok === null ? null : $transaksiBentrok->kode_agenda,
                'id_item'      => $item->id_item,
                'nama_agenda' => $transaksiBentrok?->nama_agenda,
                'tipe_agenda' => $transaksiBentrok?->tipe_agenda,
                'ket_peminjaman' => $transaksiBentrok?->ket_peminjaman,
                'nama_item'    => $item->nama_item,
                'img_item' => $transaksiBentrok?->img_item,
                'qty_diajukan'    => $item->qty_usage_item,
                'tgl_usage_pinjam' => $item->tgl_pinjam_usage_item,
                'tgl_usage_kembali' => $item->tgl_kembali_usage_item,
                'qty_bentrok'  => $bentrok,
                'status'       => ($bentrok + $item->qty_usage_item) > $item->qty_item
                    ? 'BENTROK'
                    : 'AMAN'
            ];
        });

        $usageRooms = DB::table('usage_rooms as ur')
            ->join('rooms as r', 'r.id_room', '=', 'ur.id_room')
            ->where('ur.kode_peminjaman', $kode)
            ->get();

        $hasilRoom = $usageRooms->map(function ($room) use ($kode) {
            // mengambil usage room yg bentrok
            $transaksiBentrok = DB::table('usage_rooms')
                ->leftJoin('agenda_fakultas', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
                ->leftJoin('peminjaman', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
                ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
                ->where('usage_rooms.id_room', $room->id_room)
                ->where('usage_rooms.status_usage_room', '!=', 'selesai')

                ->where(function ($q) use ($kode) {
                    $q->whereNull('usage_rooms.kode_peminjaman')
                        ->orWhere('usage_rooms.kode_peminjaman', '!=', $kode);
                })
                // ================================
                // OVERLAP TANGGAL + JAM
                // ================================
                ->where(function ($q) use ($room) {

                    // 1️⃣ OVERLAP TANGGAL
                    $q->where(function ($x) use ($room) {
                        $x->whereDate('usage_rooms.tgl_kembali_usage_room', '<=', $room->tgl_kembali_usage_room)
                            ->whereDate('usage_rooms.tgl_pinjam_usage_room', '>=', $room->tgl_pinjam_usage_room);
                    })

                        // 2️⃣ OVERLAP JAM
                        ->where(function ($x) use ($room) {

                            // A. existing FULL DAY
                            $x->where(function ($y) {
                                $y->whereNull('usage_rooms.jam_mulai_usage_room')
                                    ->whereNull('usage_rooms.jam_selesai_usage_room');
                            })

                                // B. request FULL DAY
                                ->orWhere(function ($y) use ($room) {
                                    if ($room->jam_mulai_usage_room === null && $room->jam_selesai_usage_room === null) {
                                        $y->whereRaw('1 = 1');
                                    }
                                })

                                // C. sama-sama pakai JAM
                                ->orWhere(function ($y) use ($room) {
                                    if ($room->jam_mulai_usage_room !== null && $room->jam_selesai_usage_room !== null) {
                                        $y->whereNotNull('usage_rooms.jam_mulai_usage_room')
                                            ->whereNotNull('usage_rooms.jam_selesai_usage_room')
                                            ->where('usage_rooms.jam_selesai_usage_room', '<', $room->jam_selesai_usage_room)
                                            ->where('usage_rooms.jam_mulai_usage_room', '>', $room->jam_mulai_usage_room);
                                    }
                                });
                        });
                })
                ->get()
                ->first();

            // untuk cek apakah usage room ada yg bentrok jika ada akan return bolean yg nnti berisi aman atau bentrok
            $bentrok = DB::table('usage_rooms')
                ->where('id_room', $room->id_room)
                ->where('status_usage_room', '!=', 'selesai')

                ->where(function ($q) use ($kode) {
                    $q->whereNull('kode_peminjaman')
                        ->orWhere('kode_peminjaman', '!=', $kode);
                })
                // ================================
                // OVERLAP TANGGAL + JAM
                // ================================
                ->where(function ($q) use ($room) {

                    // 1️⃣ OVERLAP TANGGAL
                    $q->where(function ($x) use ($room) {
                        $x->whereDate('tgl_kembali_usage_room', '<=', $room->tgl_kembali_usage_room)
                            ->whereDate('tgl_pinjam_usage_room', '>=', $room->tgl_pinjam_usage_room);
                    })

                        // 2️⃣ OVERLAP JAM
                        ->where(function ($x) use ($room) {

                            // A. existing FULL DAY
                            $x->where(function ($y) {
                                $y->whereNull('jam_mulai_usage_room')
                                    ->whereNull('jam_selesai_usage_room');
                            })

                                // B. request FULL DAY
                                ->orWhere(function ($y) use ($room) {
                                    if ($room->jam_mulai_usage_room === null && $room->jam_selesai_usage_room === null) {
                                        $y->whereRaw('1 = 1');
                                    }
                                })

                                // C. sama-sama pakai JAM
                                ->orWhere(function ($y) use ($room) {
                                    if ($room->jam_mulai_usage_room !== null && $room->jam_selesai_usage_room !== null) {
                                        $y->whereNotNull('jam_mulai_usage_room')
                                            ->whereNotNull('jam_selesai_usage_room')
                                            ->where('jam_selesai_usage_room', '<', $room->jam_selesai_usage_room)
                                            ->where('jam_mulai_usage_room', '>', $room->jam_mulai_usage_room);
                                    }
                                });
                        });
                })
                ->exists();

            // untuk mengambil data dari table agenda

            return [
                'kode_peminjaman_bentrok' => $transaksiBentrok === null ? null : $transaksiBentrok->kode_peminjaman,
                'kode_agenda_bentrok' => $transaksiBentrok === null ? null : $transaksiBentrok->kode_agenda,
                'nama_agenda' => $transaksiBentrok?->nama_agenda,
                'tipe_agenda' => $transaksiBentrok?->tipe_agenda,
                'ket_peminjaman' => $transaksiBentrok?->ket_peminjaman,
                'id_room' => $room->id_room,
                'nama_room' => $room->nama_room,
                'gambar_room' => $transaksiBentrok?->gambar_room,
                'tgl_usage_pinjam' => $room->tgl_pinjam_usage_room,
                'tgl_usage_kembali' => $room->tgl_kembali_usage_room,
                'status' => $bentrok ? 'BENTROK' : 'AMAN'
            ];
        });

        return [
            'barang' => $hasilItem,
            'ruangan' => $hasilRoom
        ];
        // dd();
    }

    // menghitung total pengajuan peminjaman
    public function hitungTotalPeminjaman()
    {
        $countPeminjaman = DB::table('peminjaman')
            ->whereIn('status_peminjaman', ['terjadwal', 'dipinjam'])
            ->count();

        return $countPeminjaman;
    }

    // hitung total transaksi berdasarkan status
    public function hitungTotalPenggunaanByStatus($status)
    {
        $countPeminjaman = DB::table('peminjaman')
            ->where('status_peminjaman', '=', $status)
            ->count();

        return $countPeminjaman;
    }

}
