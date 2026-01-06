<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsageRooms extends Model
{
    //
    protected $table = 'usage_rooms';
    public $incrementing = false;
    public $timestamps = true;
    protected $fillable = [
        'kode_peminjaman',
        'kode_agenda',
        'id_room',
        'tgl_pinjam_usage_room',
        'tgl_kembali_usage_room',
        'status_usage_room',
        'created_at',
        'updated_at',
        'jam_mulai_usage_room',
        'jam_selesai_usage_room',
    ];
}
