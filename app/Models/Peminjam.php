<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Peminjam extends Authenticatable
{
    protected $table = 'peminjam';
    protected $primaryKey = 'no_identitas';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'int';
    
    protected $fillable = [
        'no_identitas',
        'nama_peminjam',
        'username',
        'password',
        'fakultas',
        'prodi',
        'img_identitas',
    ];
    public function usesTimestamps()
    {
        return false;
    }
}
