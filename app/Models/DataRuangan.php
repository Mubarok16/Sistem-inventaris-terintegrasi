<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRuangan extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'id_room';
    protected $keyType = 'string';
    public $incrementing = false;
    // public $timestamps = false;

    protected $fillable = [
        'id_room',
        'id_tipe_room',
        'nama_room',
        'kondisi_room',
        'gambar_room',
    ];
}
