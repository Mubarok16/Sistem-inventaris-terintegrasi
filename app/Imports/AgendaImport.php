<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Penting unutk menjadikan heading file menjadi parameter

class AgendaImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) {
            // Mengakses data berdasarkan heading yang sudah di-slug
            $nama   = $row['nama_lengkap'];
            $email  = $row['alamat_email'];
            $status = $row['status'];

            // Contoh: Simpan ke database secara manual
            // \App\Models\User::create([
            //     'name'  => $nama,
            //     'email' => $email,
            //     'status' => $status,
            // ]);
        }
    }
}
