<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Clock\now;

class PengadaanBarangController extends Controller
{
    // menerima data pengajuan pengadaan barang dari form
    public function pengajuanPengadaanBarang(Request $request)
    {

        // mengambil data penyetuju (pimpinan wakil dekan)
        $penyetuju = DB::table('users')
            ->where('hak_akses', 'pimpinan')
            ->select(
                'id_user',
                'nama',
            )
            ->first();

        // Ambil data dari input form
        // $data = [
        //     'nomor_surat' => $request->nomor_surat,
        //     'nama_barang' => $request->nama_item,
        //     'qty'         => $request->qty,
        //     // 'alasan'      => $request->alasan,
        //     'tanggal'     => date('d F Y'),
        //     'dekan'     => $penyetuju->nama,
        //     'nidn'     => $penyetuju->id_user,
        //     'tahun_akademik' => $request->tahun_akademik,
        //     'keperluan_prodi' => $request->keperluan_prodi,
        // ];

        // Generate PDF
        // $pdf = Pdf::loadView('surat_pengadaan', $data);

        // // buat nama file surat
        // $namaFile = 'surat_' . Str::random(10) . '.pdf';
        // $path = '/surat_pengadaan_barang/' . $namaFile; // Folder storage/app/private/surat

        try {

            // dd($path);
            // Simpan ke disk 'local' (defaultnya private)
            // Storage::disk('local')->put($path, $pdf->output());

            DB::table('pengadaan_barang')->insert([
                'id_pengadaan' => $request->nomor_surat,
                'id_pemohon' => Auth::id(),
                'id_penyetuju' => null,
                'nama_item' => $request->nama_item,
                'merek_model' => $request->merk,
                'qty_item' => $request->qty,
                'surat_pengadaan' => null,
                'status_pengadaan' => "pendding",
                'tahun_akademik' => $request->tahun_akademik,
                'keperluan_prodi' => $request->keperluan_prodi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Jika sukses, redirect ke halaman index dengan pesan
            return redirect()->route('page_pengadaan_barang')->with('success', 'Surat pengadaan berhasil disimpan!');
        } catch (\Exception $e) {
            // Jika gagal
            return back()->with('gagal', 'Gagal menyimpan surat: ' . $e->getMessage());
        }
    }

    // preview pdf surat pengajuan pengadaan
    public function bukaPdf($id)
    {
        // // 1. Cari data di DB
        // $data = DB::table('pengadaan_barang')->where('id_pengadaan', base64_decode($id))->first();

        // // dd($data);

        // if (!$data || !Storage::disk('local')->exists($data->surat_pengadaan)) {
        //     abort(404, 'File tidak ditemukan.');
        // }

        // // 2. Opsi Keamanan: Hanya pemohon yang bisa lihat
        // if (Auth::id() !== $data->id_pemohon) {
        //     abort(403, 'Anda tidak memiliki akses ke file ini.');
        // }

        // // 3. Tampilkan PDF di browser
        // return Storage::disk('local')->response($data->surat_pengadaan);

        // 1. Decode ID dari URL (Menghindari masalah karakter '/' di URL)
        $nomorSuratAsli = base64_decode($id);

        // 2. Ambil data pengadaan dari database
        $dataDb = DB::table('pengadaan_barang')
            ->where('id_pengadaan', $nomorSuratAsli)
            ->first();

        if (!$dataDb) {
            abort(404, 'Data pengadaan tidak ditemukan di database.');
        }

        // 3. Opsi Keamanan: Hanya pemohon atau pimpinan yang bisa lihat
        if (Auth::id() !== $dataDb->id_pemohon && Auth::user()->hak_akses !== 'pimpinan') {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        }

        // 4. Ambil data penanda tangan (Dekan/Wakil Dekan)
        $penyetuju = DB::table('users')
            ->where('hak_akses', 'pimpinan')
            ->select('nama', 'id_user')
            ->first();

        // 5. Tentukan status Approved (Watermark akan hilang jika status 'setuju')
        $is_approved = ($dataDb->status_pengadaan === 'disetujui');

        // 6. Siapkan data untuk dikirim ke View Blade
        $data = [
            'nomor_surat'     => $dataDb->id_pengadaan,
            'nama_barang'     => $dataDb->nama_item,
            'qty'             => $dataDb->qty_item,
            'tahun_akademik'  => $dataDb->tahun_akademik,
            'keperluan_prodi' => $dataDb->keperluan_prodi,
            'dekan'           => $penyetuju->nama ?? 'Nama Belum Diatur',
            'nidn'            => $penyetuju->id_user ?? '-',
            'is_approved'     => $is_approved, // Variabel penting untuk Watermark & TTD
            'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
        ];

        // 7. Render ulang PDF agar tampilan selalu update sesuai status terbaru di DB
        $pdf = Pdf::loadView('surat_pengadaan', $data);

        // 8. Bersihkan nama file dari karakter '/' agar tidak error saat di-stream
        $namaFileAman = str_replace(['/', '\\'], '-', $nomorSuratAsli);

        // 9. Tampilkan PDF ke browser
        return $pdf->stream('Surat_Pengadaan_' . $namaFileAman . '.pdf');
    }
}
