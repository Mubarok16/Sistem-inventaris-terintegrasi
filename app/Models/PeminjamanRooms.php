<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PeminjamanRooms extends Model
{
    //
    protected $table = 'peminjaman_rooms';
    protected $primaryKey = 'id_peminjaman_room';
    public $timestamps = true;
    protected $fillable = [
        'id_peminjaman_room',
        'kode_transaksi',
        'id_room',
        'id_user',
        'no_identitas',
        'lampiran_file',
        'ket_peminjaman',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'created_at',
        'updated_at',
    ];
}
