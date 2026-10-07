<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public array $rows = [];

    /**
     * Maatwebsite Excel memanggil collection() untuk setiap worksheet jika
     * importer tidak memakai WithMultipleSheets. Template mahasiswa memiliki
     * sheet kedua "Referensi" untuk sumber dropdown prodi/status, sehingga
     * sheet tersebut tidak boleh ikut dianggap sebagai data mahasiswa.
     */
    private bool $sheetUtamaSudahDiproses = false;

    public function collection(Collection $rows)
    {
        // Hanya proses worksheet pertama (Template). Worksheet berikutnya,
        // termasuk sheet Referensi, sengaja diabaikan.
        if ($this->sheetUtamaSudahDiproses) {
            return;
        }

        $this->sheetUtamaSudahDiproses = true;

        foreach ($rows as $row) {
            $this->rows[] = $row->toArray();
        }
    }
}
