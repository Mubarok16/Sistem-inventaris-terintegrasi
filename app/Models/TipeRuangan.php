<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeRuangan extends Model
{
    protected $table = 'tipe_rooms';
    protected $primaryKey = 'id_tipe_room';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'id_tipe_room',
        'nama_tipe_room',
    ];
}
