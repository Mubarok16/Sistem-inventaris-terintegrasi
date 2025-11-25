<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Peminjaman extends Model
{

    protected $table = 'peminjaman';
    protected $primaryKey = 'kode_peminjaman';
    public $incrementing = false;
    
    protected $fillable = [
        'kode_peminjaman',
        'no_identitas',
        'id_user',
        'ket_peminjaman',
        'lampiran_file',
        'tgl_tansaksi',
        'created_at',
        'updated_at',
    ];

    // public static function getRingkasanPeminjamanGabungan()
    // {
    //      $sql = "
    //         SELECT
    //             COALESCE(pr.kode_transaksi, pi.kode_transaksi) AS kode_transaksi,
    //             pr.id_peminjaman_room,
    //             pi.id_peminjaman_item,
    //             p.nama_peminjam,
    //             COALESCE(pr.tgl_mulai, pi.tgl_pinjam_item) AS tgl_pinjam,
    //             COALESCE(pr.tgl_selesai, pi.tgl_kembali_item) AS tgl_kembali,
    //             COALESCE(pr.status, pi.status_item) AS status,
    //             COALESCE(pr.created_at, pi.created_at) AS created_at
    //         FROM
    //             peminjaman_rooms AS pr
    //         FULL JOIN
    //             peminjaman_items AS pi
    //         ON
    //             pr.kode_transaksi = pi.kode_transaksi
    //         LEFT JOIN
    //             peminjam AS p
    //         ON
    //             COALESCE(pr.no_identitas, pi.no_identitas) = p.no_identitas
    //     ";

    //     return DB::select($sql);
    // }

}
