<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'id_item';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_item',
        'id_room',
        'id_tipe_item',
        'nama_item',
        'merek_model',
        'qty_item',
        'kondisi_item',
        'img_item',
        'created_at',
        'updated_at',
    ];

    // fungsi untuk mendapatkan singkatan dari nama tipe ruangan
    public function generateIdItem($Data,$tipe,$urutan): string
    {
        $urutan = $urutan + 1; // Increment urutan untuk penomoran berikutnya
        $urutanDuadigit = str_pad($urutan, 2, '0', STR_PAD_LEFT);
        
        // 1. Pisahkan string menjadi array kata berdasarkan spasi
        $kata = explode(' ', $Data);

        if (count($kata) === 1) {
            // Jika hanya satu kata (misalnya "Laboratorium" atau "Gudang"),
            // ambil 3 huruf pertama dan jadikan huruf kapital.
            return $tipe.$urutanDuadigit.strtoupper(substr($Data, 0, 3));
        }

        $singkatan = '';

        // 2. Ambil karakter pertama (inisial) dari setiap kata
        foreach ($kata as $k) {
            // Pastikan kata tidak kosong sebelum mengambil inisial
            if (!empty($k)) {
                $singkatan .= strtoupper(substr($k, 0, 1));
            }
        }

        // dd($kata);
        return $tipe.$urutanDuadigit.strtoupper(substr($singkatan, 0, 10)); // Output: ID tipe + singkatan nama room
    }
}
