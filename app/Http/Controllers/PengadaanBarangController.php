<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PengadaanBarangController extends Controller
{
    // menerima data pengajuan pengadaan barang dari form
    public function pengajuanPengadaanBarang(Request $request)
    {
        // Ambil data dari input form
        $data = [
            'nomor_surat' => $request->nomor_surat,
            'nama_barang' => $request->nama_item,
            'qty'         => $request->qty,
            'alasan'      => $request->alasan,
            'tanggal'     => date('d F Y'),
            'tahun_akademik' => '2025/2026',
            // 'fakultas_prodi' => 'Teknik sipil Fakultas teknik',
            'dekan' => 'Dr. Ir. Hamdani Abdulgani, ST., M.Si',
            'nidn' => '007284999',
            'keperluan_prodi' => $request->keperluan_prodi,

        ];

        $pdf = Pdf::loadView('surat_pengadaan', $data);

        return $pdf->stream('Pratinjau_Surat_Pengadaan.pdf');
    }
}
