<?php

namespace App\Services\mahasiswa;

use App\Models\Peminjaman;

class RiwayatPeminjamanService
{
     // mengambil data jadwal penggunaan barang atau ruangan berdasarkan status
    public function dataPeminjamanByStatus($status)
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

}