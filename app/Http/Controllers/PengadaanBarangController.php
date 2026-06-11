<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PengadaanBarangController extends Controller
{
    // menerima data pengajuan pengadaan barang dari form
    public function pengajuanPengadaanBarang(Request $request)
    {
        // dd($request->all());

        try {

            DB::table('pengadaan_barang')->insert([
                'id_pengadaan' => $request->nomor_surat,
                'id_pemohon' => Auth::user()->id_user,
                'id_penyetuju' => null,
                'nama_item' => $request->nama_item,
                'merek_model' => $request->merk,
                'qty_item' => $request->qty,
                'status_pengadaan' => "pendding",
                'tahun_akademik' => $request->tahun_akademik,
                'keperluan_prodi' => $request->keperluan_prodi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Jika sukses, redirect ke halaman index dengan pesan
            return back()->with('success', 'Surat pengadaan berhasil disimpan!');
        } catch (\Exception $e) {
            // Jika gagal
            return back()->with('gagal', 'Gagal menyimpan surat: ' . $e->getMessage());
        }
    }

    // preview pdf surat pengajuan pengadaan
    public function bukaPdf($id)
    {
        // 1. Decode ID dari URL (Menghindari masalah karakter '/' di URL)
        $nomorSuratAsli = base64_decode($id);

        // 2. Ambil data pengadaan dari database
        $dataDb = DB::table('pengadaan_barang')
            ->leftJoin('users', 'pengadaan_barang.id_penyetuju', '=', 'users.id_user')
            ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
            ->select(
                'pengadaan_barang.*',
                'detail_dosen.nama', // Beri alias di sini
                'detail_dosen.nidn' // Beri alias di sini
            )
            ->where('id_pengadaan', $nomorSuratAsli)
            ->first();

        // dd($dataDb);

        if (!$dataDb) {
            abort(404, 'Data pengadaan tidak ditemukan di database.');
        }

        // 3. Opsi Keamanan: Hanya pemohon atau pimpinan yang bisa lihat
        if (
            Auth::user()->hak_akses !== 'admin'
            && Auth::user()->hak_akses !== 'pimpinan'
            && Auth::user()->id_user !== $dataDb->id_pemohon
        ) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        }

        // 5. Tentukan status Approved (Watermark akan hilang jika status 'setuju')
        // $is_approved = ($dataDb->status_pengadaan === 'disetujui');

        // 6. Siapkan data untuk dikirim ke View Blade
        $data = [
            'nomor_surat'     => $dataDb->id_pengadaan,
            'nama_barang'     => $dataDb->nama_item,
            'qty'             => $dataDb->qty_item,
            'tahun_akademik'  => $dataDb->tahun_akademik,
            'keperluan_prodi' => $dataDb->keperluan_prodi,
            'dekan'           => $dataDb->nama ?? 'Nama Belum Diatur',
            'nidn'            => $dataDb->nidn ?? '-',
            'is_approved'     => $dataDb->status_pengadaan, // Variabel penting untuk Watermark & TTD
            'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
            'created_at'        => $dataDb->created_at,
        ];

        // 7. Render ulang PDF agar tampilan selalu update sesuai status terbaru di DB
        $pdf = Pdf::loadView('surat_pengadaan', $data);

        // 8. Bersihkan nama file dari karakter '/' agar tidak error saat di-stream
        $namaFileAman = str_replace(['/', '\\'], '-', $nomorSuratAsli);

        // 9. Tampilkan PDF ke browser
        return $pdf->stream('Surat_Pengadaan_' . $namaFileAman . '.pdf');
    }

    // verivikasi e-sign
    public function verifikasi($id)
    {
        $nomorSurat = base64_decode($id);
        $data = DB::table('pengadaan_barang')
            ->join('users', 'pengadaan_barang.id_penyetuju', '=', 'users.id_user')
            ->join('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
            ->select(
                'pengadaan_barang.*',
                'detail_dosen.nama'

            )
            ->where('id_pengadaan', $nomorSurat)
            ->first();

        // dd($data);

        if (!$data) {
            return view('verifikasi_gagal'); // Jika dokumen tidak terdaftar
        }

        // Tampilkan halaman identitas penandatangan
        return view('components.admin.componentHalamanVerifEsign', compact('data'));
    }

    // download surat pengadaan
    public function downloadSuratPengadaan(Request $request, $id)
    {
        $id_pengadaan = base64_decode($id);

        $data = DB::table('pengadaan_barang')
            ->leftJoin('users', 'pengadaan_barang.id_penyetuju', '=', 'users.id_user')
            ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
            ->select(
                'pengadaan_barang.*',
                'detail_dosen.nama as nama_penyetuju', // Beri alias di sini
                'users.id_user' // Beri alias di sini
            )
            ->where('id_pengadaan', $id_pengadaan)
            ->first();

        // dd($data);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        // $is_approved = ($data->status_pengadaan === 'disetujui');

        // 1. Siapkan data untuk dikirim ke view blade
        $pdfData = [
            'nomor_surat'     => $data->id_pengadaan,
            'nama_barang'     => $data->nama_item,
            'qty'             => $data->qty_item,
            'tahun_akademik'  => $data->tahun_akademik,
            'keperluan_prodi' => $data->keperluan_prodi,
            'dekan'           => $data->nama_penyetuju ?? 'Nama Belum Diatur',
            'nidn'            => $data->id_user ?? '-',
            'is_approved'     => $data->status_pengadaan, // Variabel penting untuk Watermark & TTD
            'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
            'created_at'        => $data->created_at,
        ];

        // 2. Load view yang berisi desain surat Anda
        $pdf = Pdf::loadView('surat_pengadaan', $pdfData);

        // (Opsional) Atur ukuran kertas
        $pdf->setPaper('a4', 'portrait');

        // 3. Auto download dengan nama file spesifik
        return $pdf->download('Surat_Pengadaan_' . base64_encode($data->id_pengadaan) . '.pdf');

        // dd($id_pengadaan);
    }

    // page checkin barang yg telah d ajukan
    public function pageCheckInBarang($id)
    {

        if (Auth::user()->hak_akses !== "admin") {
            abort(403, 'Unauthorized');
        }

        $id_pengadaan = base64_decode($id);
        // dd($id_pengadaan);

        $AllRoom = DB::table('rooms')
            ->select(
                'id_room',
                'nama_room'
            )
            ->get();

        $pengadaan =  DB::table('pengadaan_barang')
            ->where('id_pengadaan', '=', $id_pengadaan)
            ->first();

        // dd($pengadaan);

        $halaman = 'contentDashbordChekInBarang';
        $user = Auth::user()->nama;
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'AllRoom', 'pengadaan', 'id_pengadaan'));
    }

    public function simpandistribusi(Request $request, $id)
    {
        if (Auth::user()->hak_akses !== "admin") {
            abort(403, 'Unauthorized');
        }

        $id_pengadaan = base64_decode($id);

        // Ambil data pengadaan untuk referensi (misal nama barang, kategori, dll)
        $pengadaan = DB::table('pengadaan_barang')->where('id_pengadaan', $id_pengadaan)->first();

        // generate iditem
        $DataBarang = new \App\Models\DataBarang(); // instance untuk mengakses method model

        // Bungkus dengan Transaction untuk keamanan data
        DB::beginTransaction();

        try {
            // Ambil salah satu array sebagai acuan looping (misal 'ruangan')
            // PERBAIKAN: Gunakan $request->ruangan, bukan $POST
            foreach ($request->ruangan as $index => $roomId) {

                $urutan = DB::table('items')
                    ->where('nama_item', '=', $request->nama_item)
                    ->select('nama_item')
                    ->latest()
                    ->count();


                // Ambil data lainnya juga dari $request
                $namaItem = $request->nama_item;
                $id_item = $DataBarang->generateIdItem($namaItem, Str::random(2), $urutan);
                $merkModel = $request->merk_model;
                $qty = $request->qty[$index];
                $kondisi = $request->kondisi[$index];

                // dd($DataBarang->generateIdItem($namaItem, Str::random(2), $urutan));


                // Logika simpan Anda...
                DB::table('items')->insert([
                    'id_item'      => $id_item,
                    'id_room'      => $roomId,
                    'nama_item'    => $namaItem,
                    'merek_model'  => $merkModel,
                    'qty_item'     => $qty,
                    'sumber_perolehan' => 'Universitas',
                    'tahun_perolehan' => now()->year,
                    'kondisi_item' => $kondisi,
                    'img_item'     => 'default.png',
                    'updated_at'   => now(),
                    'created_at'   => now(),
                ]);
            }
            // Update status pengadaan asal agar tidak didistribusikan dua kali
            DB::table('pengadaan_barang')
                ->where('id_pengadaan', $id_pengadaan)
                ->update([
                    'status_pengadaan' => 'selesai',
                ]);

            DB::commit();
            return redirect()->route('page_pengadaan_barang')->with('success', 'Distribusi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('page_pengadaan_barang')->with('gagal', 'Gagal menyimpan: ' . $e->getMessage());
        }

        dd($request->all());
    }
}
