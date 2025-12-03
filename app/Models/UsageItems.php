<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsageItems extends Model
{
    //
    protected $table = 'usage_items';
    public $timestamps = true;
    public $incrementing = false;
    protected $fillable = [
        'kode_peminjaman',
        'kode_agenda',
        'id_item',
        'qty_usage_item',
        'tgl_pinjam_usage_item',
        'tgl_kembali_usage_item',
        'status_usage_item',
        'created_at',
        'updated_at',
    ];
}
