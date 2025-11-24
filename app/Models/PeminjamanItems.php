<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanItems extends Model
{
    //
    protected $table = 'peminjaman_items';
    protected $primaryKey = 'id_peminjaman_item';
    public $timestamps = true;
    protected $fillable = [
        'id_peminjaman_item',
        'kode_transaksi',
        'id_user',
        'id_item',
        'no_identitas',
        'lampiran_file',
        'tanggal_pinjam_item',
        'tanggal_kembali_item',
        'qty_pinjam_item',
        'status_item',
        'created_at',
        'updated_at',
    ];
}
