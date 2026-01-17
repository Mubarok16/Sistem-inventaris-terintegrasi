<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // Penting unutk menjadikan heading file menjadi parameter
use Maatwebsite\Excel\Concerns\SkipsEmptyRows; // Penting unutk menjadikan kektika data kosong yg ada di excel akan d kosongkan

class AgendaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param Collection $collection
     */

    protected $tgl_mulai;
    protected $tgl_selesai;

    // Terima data dari Controller
    public function __construct($tgl_mulai, $tgl_selesai)
    {
        $this->tgl_mulai   = $tgl_mulai;
        $this->tgl_selesai = $tgl_selesai;
    }

    // data penampung yg akan di ambil di controller
    public $dataHasilOlahan = []; // Properti penampung

    public function collection(Collection $rows)
    {
        // loop untuk mengambil semua data dari exel
        foreach ($rows as $row) {
            // Mengakses data berdasarkan heading yang ada di exel
            $kode_mk = $row['kode_mk'];
            $nama_agenda   = $row['matakuliah'];
            $ruangan  = $row['ruang'];
            $Hari = $row['hari'] ?? null; // null jika file yg d inputkan itu agenda PTS dan PAS
            $Tanggal_raw = $row['tanggal'] ?? null; // null jika file yg d inputkan itu agenda matakuliah
            $waktu_raw = $row['waktu'];

            $tgl_mulai = $this->tgl_mulai;
            $tgl_selesai = $this->tgl_selesai;

            // Jika datanya berupa angka (numeric), konversi dari Excel date
            if (is_numeric($Tanggal_raw)) {
                $Tanggal = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Tanggal_raw))->format('Y-m-d');
            } else {
                $Tanggal = $Tanggal_raw; // Jika sudah string (misal: "09:00")
            }

            // Jika datanya berupa angka (numeric), konversi dari Excel date
            if (is_numeric($waktu_raw)) {
                $waktu = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($waktu_raw))->format('H:i');
            } else {
                $waktu = $waktu_raw; // Jika sudah string (misal: "09:00")
            }

            $this->dataHasilOlahan[] = [
                'kode_agenda' => $kode_mk,
                'nama_agenda' => $nama_agenda,
                'ruangan' => $ruangan,
                'hari' => $Hari,
                'tanggal' => $Tanggal,
                'jam' => $waktu,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai
            ];
        }
    }
}
