<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataRuangan;
use App\Services\Admin\PengelolaanAgendaService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Clock\now;

class PerawatanBarang extends Controller
{
    // page ajukan perawatan barang

    public function PagePengajuanPerawatanBarang(Request $request)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $dataBarang = DataBarang::join('rooms', 'items.id_room', 'rooms.id_room')
            ->select('items.*', 'rooms.nama_room')
            ->latest() // Pilih kolom yang diperlukan
            ->get();
        // dd($dataBarang);

        $dataRoom = DataRuangan::join('tipe_rooms', 'rooms.id_tipe_room', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room')
            ->latest() // Pilih kolom yang diperlukan
            ->get();

        // mengambil data barang dan rungan yg di input user di session
        $semuaData = collect(session('data_perawatan_barang_ruang'));
        // mengambil data tambh agenda yg di input admin
        $dataAgenda = collect(session('data_header_perawatan_temp'));

        // dd($semuaData);

        // mengambil semua data barang dan ruangan
        $PengelolaanAgendaService = new PengelolaanAgendaService;
        $allBarangRuang = $PengelolaanAgendaService->getBarangDanRaung()->toArray();

        // dd($allBarangRuang);

        $user = Auth::user()->nama;
        $halaman = 'contentPengajuanPerawatanBarang';
        return view('Page_admin.dashboard-admin', compact(
            'halaman',
            'user',
            'dataBarang',
            'dataRoom',
            'semuaData',
            'allBarangRuang',
            'dataAgenda'
        ));
    }

    public function kunciInputPerawatan(Request $request)
    {
        // dd($request->all());

        try {

            DB::table('perawatan_barang')->insert([
                'id_perawatan' => $request->nomor_surat,
                'id_pemohon' => Auth::user()->id_user,
                'id_penyetuju' => null,
                'id_item' => $request->category == 'barang' ? $request->id_item_room : null,
                'id_room' => $request->category == 'barang' ? null : $request->id_item_room,
                'qty_perawatan' => $request->category == 'barang' ? $request->qty_usage : null,
                // 'surat_pengadaan' => null,
                'status_perawatan' => "pendding",
                'tahun_akademik' => $request->tahun_akademik,
                'keperluan_prodi' => $request->kebutuhan_prodi,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // jika barang maka qty yg ada di table items akan d kurangi yg diajaukan perawatannya
            if ($request->category == 'barang') {
                $item = DB::table('items')
                    ->where('id_item', $request->id_item_room) // Pastikan ada filter ID
                    ->select(
                        'qty_item'
                    )
                    ->first();

                $jmlh_item = $item->qty_item;
                // dd($jmlh_item - $request->qty_usage);

                // jika barang yg d ajukan perawatan itu < dari jmlh semua barang di tabel item maka yg d update qty item nya saja 
                if ($request->qty_usage < $jmlh_item) {
                    DB::table('items')
                        ->where('id_item', $request->id_item_room) // Pastikan ada filter ID
                        ->update([
                            'qty_item' => $jmlh_item - $request->qty_usage,
                            'updated_at' => now(), // Sangat disarankan untuk update timestamp manual di Query Builder
                        ]);

                    return back()->with('success', 'Surat pengajuan perawatan berhasil disimpan!');
                } else {
                    // jika barang yg d ajukan perawatan itu = dari jmlh semua barang di tabel item maka yg d update qty dan visibility itemnya agar tidak bisa d pinjam
                    DB::table('items')
                        ->where('id_item', $request->id_item_room) // Pastikan ada filter ID
                        ->update([
                            'qty_item' => $jmlh_item - $request->qty_usage,
                            'kondisi_item' => 'Rusak',
                            'visibility_item' => '0',
                            'updated_at' => now(), // Sangat disarankan untuk update timestamp manual di Query Builder
                        ]);
                    return back()->with('success', 'Surat pengajuan perawatan berhasil disimpan!');
                }
            } else {
                // jika ruangan maka status visibilitynya tidak bisa d pinjam
                DB::table('rooms')
                    ->where('id_room', $request->id_item_room) // Pastikan ada filter ID
                    ->update([
                        'visibility_room' => '0',
                        'kondisi_room' => 'Rusak',
                        'updated_at' => now(), // Sangat disarankan untuk update timestamp manual di Query Builder
                    ]);
                return back()->with('success', 'Surat pengajuan perawatan berhasil disimpan!');
            }
        } catch (\Exception $e) {
            // Jika gagal
            return back()->with('gagal', 'Gagal menyimpan surat: ' . $e->getMessage());
        }
    }

    public function bukaPdf($id)
    {
        // dd($id);
        // Hanya admin kaprodi dan pimpinan yang bisa lihat
        if (Auth::user()->hak_akses !== 'admin' && Auth::user()->hak_akses !== 'pimpinan' && Auth::user()->hak_akses !== 'kaprodi') {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        }

        // 1. Decode ID dari URL (Menghindari masalah karakter '/' di URL)
        $nomorSuratAsli = base64_decode($id);

        // 2. Ambil data pengadaan dari database
        $dataDb = DB::table('perawatan_barang')
            ->leftJoin('users', 'perawatan_barang.id_penyetuju', '=', 'users.id_user')
            ->leftJoin('items', 'items.id_item', '=', 'perawatan_barang.id_item')
            ->leftJoin('rooms', 'rooms.id_room', '=', 'perawatan_barang.id_room')
            ->select(
                'perawatan_barang.*',
                'users.nama', // Beri alias di sini
                'users.id_user', // Beri alias di sini
                'items.nama_item',
                'items.merek_model',
                'rooms.nama_room',
            )
            ->where('id_perawatan', $nomorSuratAsli)
            ->first();

        // dd($dataDb);

        if (!$dataDb) {
            abort(404, 'Data pengadaan tidak ditemukan di database.');
        }

        // 5. Tentukan status Approved (Watermark akan hilang jika status 'setuju')
        // $is_approved = ($dataDb->status_perawatan === 'disetujui');

        // 6. Siapkan data untuk dikirim ke View Blade
        $data = [
            'nomor_surat'     => $dataDb->id_perawatan,
            'nama_barang'     => $dataDb->nama_item == null ?  $dataDb->nama_room :  $dataDb->nama_item,
            'merek_model'     => $dataDb->merek_model,
            'qty'             => $dataDb->qty_perawatan == null ? 'Ruangan' : $dataDb->qty_perawatan,
            'tahun_akademik'  => $dataDb->tahun_akademik,
            'keperluan_prodi' => $dataDb->keperluan_prodi,
            'dekan'           => $dataDb->nama ?? 'Nama Belum Diatur',
            'nidn'            => $dataDb->id_user ?? '-',
            'is_approved'     => $dataDb->status_perawatan, // Variabel penting untuk Watermark & TTD
            'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
            'kategori'        => $dataDb->nama_item == null ? 'prasarana' : 'sarana',
            'created_at'        => $dataDb->created_at,
        ];

        // 7. Render ulang PDF agar tampilan selalu update sesuai status terbaru di DB
        $pdf = Pdf::loadView('surat_perawatan', $data);

        // 8. Bersihkan nama file dari karakter '/' agar tidak error saat di-stream
        $namaFileAman = str_replace(['/', '\\'], '-', $nomorSuratAsli);

        // 9. Tampilkan PDF ke browser
        return $pdf->stream('Surat_Perawatan_' . $namaFileAman . '.pdf');
    }

    public function downloadSuratPerawatan($id)
    {
        // dd($id);
        // Hanya admin kaprodi dan pimpinan yang bisa lihat
        if (Auth::user()->hak_akses !== 'admin' && Auth::user()->hak_akses !== 'pimpinan' && Auth::user()->hak_akses !== 'kaprodi') {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        }

        $id_perawatan = base64_decode($id);

        $data = DB::table('perawatan_barang')
            ->leftJoin('users', 'perawatan_barang.id_penyetuju', '=', 'users.id_user')
            ->leftJoin('items', 'items.id_item', '=', 'perawatan_barang.id_item')
            ->leftJoin('rooms', 'rooms.id_room', '=', 'perawatan_barang.id_room')
            ->select(
                'perawatan_barang.*',
                'users.nama as nama_penyetuju', // Beri alias di sini
                'users.id_user', // Beri alias di sini
                'items.nama_item',
                'items.merek_model',
                'rooms.nama_room',
            )
            ->where('id_perawatan', $id_perawatan)
            ->first();

        // Hanya pemohon kaprodi dan pimpinan yang bisa lihat
        // if (Auth::id() !== $data->id_pemohon && Auth::user()->hak_akses !== 'pimpinan' && Auth::user()->hak_akses !== 'kaprodi') {
        //     abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        // }

        // dd($data);

        if (!$data) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $is_approved = ($data->status_perawatan === 'disetujui');

        // 1. Siapkan data untuk dikirim ke view blade
        $pdfData = [
            'nomor_surat'     => $data->id_perawatan,
            'nama_barang'     => $data->nama_item == null ?  $data->nama_room :  $data->nama_item,
            'merek_model'     => $data->merek_model,
            'qty'             => $data->qty_perawatan == null ? 'Ruangan' : $data->qty_perawatan,
            'tahun_akademik'  => $data->tahun_akademik,
            'keperluan_prodi' => $data->keperluan_prodi,
            'dekan'           => $data->nama ?? 'Nama Belum Diatur',
            'nidn'            => $data->id_user ?? '-',
            'is_approved'     => $data->status_perawatan, // Variabel penting untuk Watermark & TTD
            'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
            'kategori'        => $data->nama_item == null ? 'prasarana' : 'sarana',
            'created_at'        => $data->created_at,
        ];

        // 2. Load view yang berisi desain surat Anda
        $pdf = Pdf::loadView('surat_perawatan', $pdfData);

        // (Opsional) Atur ukuran kertas
        $pdf->setPaper('a4', 'portrait');

        // 3. Auto download dengan nama file spesifik
        return $pdf->download('Surat_Perawatan_' . base64_encode($data->id_perawatan) . '.pdf');
    }

    // page checkin perawatan yg telah selesai d perbaiki
    public function pageCheckInPerawatan($id)
    {

        if (Auth::user()->hak_akses !== "admin") {
            abort(403, 'Unauthorized');
        }

        $id_perawatan = base64_decode($id);
        // dd($id_perawatan);

        $dataDb = DB::table('perawatan_barang')
            ->select(
                'perawatan_barang.*',
            )
            ->where('id_perawatan', $id_perawatan)
            ->first();

        $item = DB::table('items')
            ->select(
                'items.*',
            )
            ->where('id_item', $dataDb->id_item)
            ->first();

        if ($dataDb->id_item != null) {
            // jika perawatan item
            DB::table('items')
                ->where('id_item', $dataDb->id_item)
                ->update([
                    'qty_item' => $dataDb->qty_perawatan + $item->qty_item,
                    'kondisi_item' => 'Baik',
                    'updated_at' => now(), // Opsional, jika ingin manual
                ]);

            DB::table('perawatan_barang')
                ->where('id_perawatan', $id_perawatan)
                ->update([
                    'status_perawatan' => 'selesai',
                    // 'kondisi_item' => 'Baik',
                    'updated_at' => now(), // Opsional, jika ingin manual
                ]);
        } else {
            DB::table('rooms')
                ->where('id_room', $dataDb->id_room)
                ->update([
                    // 'qty_item' => $dataDb->qty_perawatan,
                    'kondisi_room' => 'Baik',
                    'updated_at' => now(), // Opsional, jika ingin manual
                ]);

            DB::table('perawatan_barang')
                ->where('id_perawatan', $id_perawatan)
                ->update([
                    'status_perawatan' => 'selesai',
                    // 'kondisi_item' => 'Baik',
                    'updated_at' => now(), // Opsional, jika ingin manual
                ]);
        }
        // dd($dataDb);
        return back()->with('succes', 'perawatan selesai item berhasil di berbaharui!');
    }
}
