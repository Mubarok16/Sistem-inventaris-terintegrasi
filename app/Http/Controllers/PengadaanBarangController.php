<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PengadaanBarangController extends Controller
{
    // menerima data dari form
    public function pengajuanPengadaanBarang(Request $request)
    {


        $nomor_surat = $request->nomor_surat;
        $nama_item = $request->nama_item;
        $merk = $request->merk;
        $qty = $request->qty;


        dd($request->all());
    }

    public function cetakPdf(Request $request)
    {
        // 1. Ambil data dari input form
        $data = [
            'nama_barang' => $request->nama_item,
            'qty'         => $request->qty,
            'alasan'      => $request->alasan,
            'tanggal'     => date('d F Y'),
            'tahun_akademik' => '2025/2026',
            'prodi' => 'teknik komputer',
            'dekan' => 'Dr. Ir. Hamdani Abdulgani, ST., M.Si',
            'nidn' => '007284999',

        ];

        // // 2. Load View khusus untuk tampilan PDF
        // $pdf = Pdf::loadView('pdf.surat_pengadaan', $data);

        // // 3. Atur ukuran kertas (opsional, default A4)
        // $pdf->setPaper('a4', 'portrait');

        // // 4. Stream untuk melihat di browser atau download() untuk langsung unduh
        // return $pdf->stream('Surat_Pengajuan_' . $request->nama_barang . '.pdf');

        $pdf = Pdf::loadView('surat_pengadaan', $data);

        return $pdf->stream('Pratinjau_Surat_Pengadaan.pdf');
    }
}
