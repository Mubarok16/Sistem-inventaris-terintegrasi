<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipeBarang extends Model
{
    protected $table = 'tipe_item';
    protected $primaryKey = 'id_tipe_item';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id_tipe_item',
        'nama_tipe_item',
    ];

    // fungsi untuk mendapatkan singkatan dari nama tipe ruangan
    public function getSingkatanAttribute($TipeRuangan): string
    {
        // 1. Pisahkan string menjadi array kata berdasarkan spasi
        $kata = explode(' ', $TipeRuangan);

        if (count($kata) === 1) {
            // Jika hanya satu kata (misalnya "Laboratorium" atau "Gudang"),
            // ambil 3 huruf pertama dan jadikan huruf kapital.
            return strtoupper(substr($TipeRuangan, 0, 3));
        }

        $singkatan = '';

        // 2. Ambil karakter pertama (inisial) dari setiap kata
        foreach ($kata as $k) {
            // Pastikan kata tidak kosong sebelum mengambil inisial
            if (!empty($k)) {
                $singkatan .= strtoupper(substr($k, 0, 1));
            }
        }

        return $singkatan; // Output: "RK"
    }
}
