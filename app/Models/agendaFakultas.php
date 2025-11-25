<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class agendaFakultas extends Model
{
    protected $table = 'agenda_fakultas';
    protected $primaryKey = 'kode_agenda';
    public $incrementing = false;
    
    protected $fillable = [
        'kode_agenda',
        'id_user',
        'nama_agenda',
        'tgl_add_agenda',
        'created_at',
        'updated_at',
    ];
}
