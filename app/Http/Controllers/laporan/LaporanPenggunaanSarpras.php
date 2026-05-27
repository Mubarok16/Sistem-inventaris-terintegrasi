<?php

namespace App\Http\Controllers\laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class LaporanPenggunaanSarpras extends Controller
{
    // preview pdf surat pengajuan pengadaan
    public function bukaPdf($date)
    {
        // 1. Decode ID dari URL (Menghindari masalah karakter '/' di URL)
        $date = $date;

        // createFromFormat jauh lebih aman karena memberi tahu Carbon bentuk asli inputnya (m-Y)
        $carbonDate = Carbon::createFromFormat('Y-m', $date)->locale('id');

        // Sekarang Anda bisa mengambil bulan dan tahun dengan aman tanpa error
        $bulan = $carbonDate->isoFormat('M'); // Hasil: Mei
        $tahun = $carbonDate->isoFormat('YYYY'); // Hasil: 2026

        // return strtolower($bulan); // Hasil: januari
        // dd($bulan, $tahun);

        // 2. Ambil data pengadaan dari database
        $dataPenggunaanBarang = DB::table('usage_items')
            // Hubungkan ke tabel items untuk mengambil nama barang (opsional jika ada tabelnya)
            ->leftJoin('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select(
                'usage_items.id_item',
                'items.nama_item', // Ambil nama barang jika di-join
                'items.merek_model', // Ambil nama barang jika di-join
                DB::raw('SUM(usage_items.qty_usage_item) as total_qty') // Menjumlahkan qty_pinjam
            )
            ->where('usage_items.status_usage_item', 'selesai') // Hanya hitung yang sudah selesai
            ->whereMonth('usage_items.tgl_pinjam_usage_item', $bulan)
            ->whereYear('usage_items.tgl_pinjam_usage_item', $tahun)
            ->groupBy('usage_items.id_item') // Wajib dikelompokkan berdasarkan id_item
            ->groupBy('items.nama_item') // Ikut dikelompokkan jika menggunakan join nama barang
            ->groupBy('items.merek_model') // Ikut dikelompokkan jika menggunakan join merek_model
            ->get(); // Gunakan ->get() karena datanya berupa list/banyak baris

        $dataPenggunaanRuangan = DB::table('usage_rooms')
            // Hubungkan ke tabel rooms untuk mengambil nama ruangan (opsional jika ada tabelnya)
            ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->leftJoin('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select(
                'usage_rooms.id_room',
                'rooms.nama_room', // Ambil nama ruangan jika di-join
                'tipe_rooms.nama_tipe_room', // Ambil nama tipe ruangan jika di-join
                DB::raw('COUNT(usage_rooms.id_room) as total_usage') // Menjumlahkan qty_pinjam
            )
            ->where('usage_rooms.status_usage_room', 'selesai') // Hanya hitung yang sudah selesai
            ->whereMonth('usage_rooms.tgl_pinjam_usage_room', $bulan)
            ->whereYear('usage_rooms.tgl_pinjam_usage_room', $tahun)
            ->groupBy('usage_rooms.id_room') // Wajib dikelompokkan berdasarkan id_room
            ->groupBy('rooms.nama_room') // Ikut dikelompokkan jika menggunakan join nama ruangan
            ->groupBy('tipe_rooms.nama_tipe_room') // Ikut dikelompokkan jika menggunakan join nama tipe ruangan
            ->get(); // Gunakan ->get() karena datanya berupa list/banyak baris

        // dd($dataPenggunaanBarang, $dataPenggunaanRuangan);

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
        $data = [
            'bulan'     => $bulan,
            'tahun'     => $tahun,
            'dataPenggunaanBarang' => $dataPenggunaanBarang,
            'dataPenggunaanRuangan' => $dataPenggunaanRuangan,
            // 'nama_barang'     => $dataDb->nama_item,
            // 'qty'             => $dataDb->qty_item,
            // 'tahun_akademik'  => $dataDb->tahun_akademik,
            // 'keperluan_prodi' => $dataDb->keperluan_prodi,
            // 'dekan'           => $dataDb->nama ?? 'Nama Belum Diatur',
            // 'nidn'            => $dataDb->id_user ?? '-',
            // 'is_approved'     => $dataDb->status_pengadaan, // Variabel penting untuk Watermark & TTD
            // 'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
            // 'created_at'        => $dataDb->created_at,
        ];

        // 7. Render ulang PDF agar tampilan selalu update sesuai status terbaru di DB
        // $pdf = Pdf::loadView('surat_pengadaan', $data);
        $pdf = Pdf::loadView('laporan_penggunaan_resource', $data);

        // 8. Bersihkan nama file dari karakter '/' agar tidak error saat di-stream
        $namaFileAman = str_replace(['/', '\\'], '-', '');

        // 9. Tampilkan PDF ke browser
        return $pdf->stream('laporan_penggunaan_sarpras' . $namaFileAman . '.pdf');
    }
}
