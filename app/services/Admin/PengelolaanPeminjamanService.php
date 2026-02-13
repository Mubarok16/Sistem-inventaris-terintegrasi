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
            // ->where('ui.kode_peminjaman', $kode)
            ->where(function ($q) use ($kode) {
                $q->where('ui.kode_peminjaman', $kode)
                    ->orWhere('ui.kode_agenda', $kode); // Tambahkan ini
            })
            ->select(
                'ui.*',
                'i.nama_item',
                'i.qty_item',
                'i.img_item'
            )
            ->get();

        $hasilItem = $usageItems->flatMap(function ($item) use ($kode) {
            $listTransaksiBentrok = DB::table('usage_items')
                ->leftJoin('agenda_fakultas', 'usage_items.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
                ->leftJoin('peminjaman', 'usage_items.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
                ->leftJoin('items', 'usage_items.id_item', '=', 'items.id_item')
                ->where('usage_items.id_item', $item->id_item)
                ->whereNotIn('usage_items.status_usage_item', ['selesai', 'ditolak'])
                ->where(function ($q) use ($kode) {
                    $q->where(function ($x) use ($kode) {
                        $x->whereNotNull('usage_items.kode_peminjaman')
                            ->where('usage_items.kode_peminjaman', '!=', $kode);
                    })
                        ->orWhere(function ($x) use ($kode) {
                            $x->whereNotNull('usage_items.kode_agenda')
                                ->where('usage_items.kode_agenda', '!=', $kode);
                        });
                })
                ->where(function ($q) use ($item) {
                    $q->whereDate('usage_items.tgl_pinjam_usage_item', '<=', $item->tgl_kembali_usage_item)
                        ->whereDate('usage_items.tgl_kembali_usage_item', '>=', $item->tgl_pinjam_usage_item);
                })
                ->where(function ($q) use ($item) {
                    $q->where(function ($x) {
                        $x->whereNull('usage_items.jam_mulai_usage_item')
                            ->orWhereNull('usage_items.jam_selesai_usage_item');
                    })
                        ->orWhere(function ($x) use ($item) {
                            if ($item->jam_mulai_usage_item === null) {
                                $x->whereRaw('1 = 1');
                            } else {
                                $x->whereNotNull('usage_items.jam_mulai_usage_item')
                                    ->where('usage_items.jam_mulai_usage_item', '<', $item->jam_selesai_usage_item)
                                    ->where('usage_items.jam_selesai_usage_item', '>', $item->jam_mulai_usage_item);
                            }
                        });
                })
                ->select(
                    'usage_items.*',
                    'agenda_fakultas.nama_agenda',
                    'peminjaman.ket_peminjaman',
                    'items.qty_item as stok_master'
                )
                ->get();

            $totalQtyTerpakai = $listTransaksiBentrok->sum('qty_usage_item');
            $stokTersedia = $item->qty_item ?? 0;
            $isBentrokStok = ($totalQtyTerpakai + $item->qty_usage_item) > $stokTersedia;
            $gambarAman = $item->img_item;

            // JIKA TIDAK ADA TRANSAKSI LAIN ATAU STOK MASIH CUKUP
            if ($listTransaksiBentrok->isEmpty() || !$isBentrokStok) {
                return [[
                    'kode_peminjaman_bentrok' => null,
                    'kode_agenda_bentrok'     => null,
                    'tipe_agenda'             => null, // Key ditambahkan agar tidak undefined
                    'id_item'                 => $item->id_item,
                    'nama_item'               => $item->nama_item,
                    'img_item'                => $gambarAman,
                    'qty_diajukan'            => $item->qty_usage_item,
                    'qty_bentrok'             => $totalQtyTerpakai,
                    'status'                  => 'AMAN',
                    'nama_agenda'             => 'Tersedia',
                    'keterangan'              => 'Stok masih tersedia'
                ]];
            }

            // JIKA BENTROK
            return $listTransaksiBentrok->map(function ($bentrok) use ($item, $totalQtyTerpakai, $gambarAman) {
                return [
                    'kode_peminjaman_bentrok' => $bentrok->kode_peminjaman ?? null,
                    'kode_agenda_bentrok'     => $bentrok->kode_agenda ?? null,
                    'tipe_agenda'             => $bentrok->kode_agenda ? 'Agenda' : 'Peminjaman', // Penentu tipe
                    'id_item'                 => $item->id_item,
                    'nama_item'               => $item->nama_item,
                    'img_item'                => $gambarAman,
                    'nama_agenda'             => $bentrok->nama_agenda ?? ($bentrok->ket_peminjaman ?? 'Agenda Lain'),
                    'qty_diajukan'            => $item->qty_usage_item,
                    'qty_bentrok'             => $totalQtyTerpakai,
                    'status'                  => 'BENTROK',
                    'keterangan'              => 'Stok tidak mencukupi'
                ];
            });
        })
            ->unique(function ($res) {
                // Unique key yang lebih aman
                $identifier = $res['kode_peminjaman_bentrok'] ?? ($res['kode_agenda_bentrok'] ?? uniqid('id_'));
                return $identifier . $res['id_item'] . $res['status'];
            })
            ->values();

        ////////////////////////////////  rooms  //////////////////////////////////////////////

        $usageRooms = DB::table('usage_rooms as ur')
            ->join('rooms as r', 'r.id_room', '=', 'ur.id_room')
            // ->where('ur.kode_peminjaman', $kode)
            ->where(function ($q) use ($kode) {
                $q->where('ur.kode_peminjaman', $kode)
                    ->orWhere('ur.kode_agenda', $kode); // Tambahkan ini
            })
            ->select('ur.*', 'r.nama_room', 'r.gambar_room')
            ->get();

        $hasilRoom = $usageRooms->flatMap(function ($room) use ($kode) {
            $listTransaksiBentrok = DB::table('usage_rooms')
                ->leftJoin('agenda_fakultas', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
                ->leftJoin('peminjaman', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
                ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
                ->where('usage_rooms.id_room', $room->id_room)
                ->where('usage_rooms.status_usage_room', '!=', 'selesai')
                ->where('usage_rooms.status_usage_room', '!=', 'diajukan')
                ->where('usage_rooms.status_usage_room', '!=', 'ditolak')
                ->where(function ($q) use ($kode) {
                    $q->where(function ($x) use ($kode) {
                        // Jika itu peminjaman, kodenya tidak boleh sama dengan $kode
                        $x->whereNotNull('usage_rooms.kode_peminjaman')
                            ->where('usage_rooms.kode_peminjaman', '!=', $kode);
                    })
                        ->orWhere(function ($x) use ($kode) {
                            // Jika itu agenda, kodenya juga tidak boleh sama dengan $kode
                            $x->whereNotNull('usage_rooms.kode_agenda')
                                ->where('usage_rooms.kode_agenda', '!=', $kode);
                        });
                })

                // === TEMPAT LOGIKA OVERLAP TANGGAL & JAM ===
                ->where(function ($q) use ($room) {
                    // 1️⃣ CEK BENTROK TANGGAL
                    // Rumus: StartA <= EndB AND EndA >= StartB
                    $q->where(function ($x) use ($room) {
                        $x->whereDate('usage_rooms.tgl_pinjam_usage_room', '<=', $room->tgl_kembali_usage_room)
                            ->whereDate('usage_rooms.tgl_kembali_usage_room', '>=', $room->tgl_pinjam_usage_room);
                    })
                        // 2️⃣ CEK BENTROK JAM (Jika tanggal sudah kena, cek jamnya)
                        ->where(function ($x) use ($room) {
                            // Kasus A: Data di DB adalah Full Day (NULL jamnya) -> Pasti bentrok
                            $x->where(function ($y) {
                                $y->whereNull('usage_rooms.jam_mulai_usage_room')
                                    ->whereNull('usage_rooms.jam_selesai_usage_room');
                            })
                                // Kasus B: Request baru adalah Full Day -> Pasti bentrok
                                ->orWhere(function ($y) use ($room) {
                                    if ($room->jam_mulai_usage_room === null) {
                                        $y->whereRaw('1 = 1');
                                    }
                                })
                                // Kasus C: Keduanya pakai jam -> Cek irisan jamnya
                                ->orWhere(function ($y) use ($room) {
                                    if ($room->jam_mulai_usage_room !== null) {
                                        $y->where('usage_rooms.jam_mulai_usage_room', '<', $room->jam_selesai_usage_room)
                                            ->where('usage_rooms.jam_selesai_usage_room', '>', $room->jam_mulai_usage_room);
                                    }
                                });
                        });
                })
                // ==========================================

                ->select(
                    'usage_rooms.kode_peminjaman',
                    'usage_rooms.kode_agenda',
                    'agenda_fakultas.nama_agenda',
                    'agenda_fakultas.tipe_agenda',
                    'peminjaman.ket_peminjaman',
                    'rooms.nama_room'
                )
                ->get();

            // ... (sisa kode return AMAN/BENTROK Anda tetap sama) ...
            if ($listTransaksiBentrok->isEmpty()) {
                return [[
                    'kode_peminjaman_bentrok' => null,
                    'kode_agenda_bentrok'     => null,
                    'nama_agenda'             => null,
                    'tipe_agenda'             => null,
                    'ket_peminjaman'          => null,
                    'id_room'                 => $room->id_room,
                    'nama_room'               => $room->nama_room,
                    'gambar_room'             => $room->gambar_room,
                    'tgl_usage_pinjam'        => $room->tgl_pinjam_usage_room,
                    'tgl_usage_kembali'       => $room->tgl_kembali_usage_room,
                    'status'                  => 'AMAN',
                ]];
            }

            return $listTransaksiBentrok->map(function ($bentrok) use ($room) {
                return [
                    'kode_peminjaman_bentrok' => $bentrok->kode_peminjaman ?? null,
                    'kode_agenda_bentrok'     => $bentrok->kode_agenda ?? null,
                    'nama_agenda'             => $bentrok->nama_agenda ?? null,
                    'tipe_agenda'             => $bentrok->tipe_agenda ?? null,
                    'ket_peminjaman'          => $bentrok->ket_peminjaman ?? null,
                    'id_room'                 => $room->id_room,
                    'nama_room'               => $room->nama_room,
                    'gambar_room'             => $room->gambar_room,
                    'tgl_usage_pinjam'        => $room->tgl_pinjam_usage_room,
                    'tgl_usage_kembali'       => $room->tgl_kembali_usage_room,
                    'status'                  => 'BENTROK',
                ];
            });
        })
            ->unique(function ($item) {
                $identifier = $item['kode_peminjaman_bentrok'] ?? $item['kode_agenda_bentrok'];
                return $identifier . $item['id_room'];
            })
            ->values();


        return [
            'barang' => $hasilItem,
            'ruangan' => $hasilRoom
        ];
        // dd($usageRooms);
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
