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
        'tgl_mulai_agenda',
        'tgl_selesai_agenda',
        'tipe_agenda',
        'created_at',
        'updated_at',
    ];

    public function generateIdAgenda($nama,$tipe): string
    {
        // $urutan = $urutan + 1; // Increment urutan untuk penomoran berikutnya
        // $urutanDuadigit = str_pad($urutan, 2, '0', STR_PAD_LEFT);
        $tipe_singkat = '';
        if ($tipe === 'kegiatan belajar mengajar') {
            $tipe_singkat = '-KBM';
        }elseif ($tipe === 'Rapat pimpinan') {
            $tipe_singkat = '-RPMPN';
        }elseif ($tipe === 'seminar/sidang') {
            $tipe_singkat = '-SMNR-SDNG';
        }
        // 1. Pisahkan string menjadi array kata berdasarkan spasi
        $kata = explode(' ', $nama);

        $singkatan = '';

        // 2. Ambil karakter pertama (inisial) dari setiap kata
        foreach ($kata as $k) {
            // Pastikan kata tidak kosong sebelum mengambil inisial
            if (!empty($k)) {
                $singkatan .= strtoupper(substr($k, 0, 1));
            }
        }

        return $singkatan.$tipe_singkat;
    }
}
