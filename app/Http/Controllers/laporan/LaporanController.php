<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Clock\now;

class LaporanController extends Controller
{
    // preview pdf surat pengajuan pengadaan
    public function bukaPdf()
    {
        // 1. Decode ID dari URL (Menghindari masalah karakter '/' di URL)
        // $nomorSuratAsli = base64_decode($id);

        // 2. Ambil data pengadaan dari database
        // $dataDb = DB::table('pengadaan_barang')
        //     ->leftJoin('users', 'pengadaan_barang.id_penyetuju', '=', 'users.id_user')
        //     ->select(
        //         'pengadaan_barang.*',
        //         'users.nama', // Beri alias di sini
        //         'users.id_user' // Beri alias di sini
        //     )
        //     ->where('id_pengadaan', $nomorSuratAsli)
        //     ->first();

        // if (!$dataDb) {
        //     abort(404, 'Data pengadaan tidak ditemukan di database.');
        // }

        // // 3. Opsi Keamanan: Hanya pemohon atau pimpinan yang bisa lihat
        // if (Auth::id() !== $dataDb->id_pemohon && Auth::user()->hak_akses !== 'pimpinan') {
        //     abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        // }

        // // 5. Tentukan status Approved (Watermark akan hilang jika status 'setuju')
        // // $is_approved = ($dataDb->status_pengadaan === 'disetujui');

        // // 6. Siapkan data untuk dikirim ke View Blade
        // $data = [
        //     'nomor_surat'     => $dataDb->id_pengadaan,
        //     'nama_barang'     => $dataDb->nama_item,
        //     'qty'             => $dataDb->qty_item,
        //     'tahun_akademik'  => $dataDb->tahun_akademik,
        //     'keperluan_prodi' => $dataDb->keperluan_prodi,
        //     'dekan'           => $dataDb->nama ?? 'Nama Belum Diatur',
        //     'nidn'            => $dataDb->id_user ?? '-',
        //     'is_approved'     => $dataDb->status_pengadaan, // Variabel penting untuk Watermark & TTD
        //     'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
        //     'created_at'        => $dataDb->created_at,
        // ];

        // 7. Render ulang PDF agar tampilan selalu update sesuai status terbaru di DB
        // $pdf = Pdf::loadView('surat_pengadaan', $data);
        $pdf = Pdf::loadView('surat_pengadaan');

        // 8. Bersihkan nama file dari karakter '/' agar tidak error saat di-stream
        $namaFileAman = str_replace(['/', '\\'], '-', 'asdasd');

        // 9. Tampilkan PDF ke browser
        return $pdf->stream('laporan_penggunaan_resource' . $namaFileAman . '.pdf');
    }
}