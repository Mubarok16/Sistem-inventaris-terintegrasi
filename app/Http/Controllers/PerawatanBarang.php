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
        // $dataAgendaTemp = $request->session()->get('data_input_agenda', []);
        // $dataAgendaBarangTemp = $request->session()->get('data_input_barang', []);
        // $dataAgendaRuanganTemp = $request->session()->get('data_input_ruangan', []);

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
            // 'dataAgendaTemp',
            // 'dataAgendaRuanganTemp',
            // 'dataAgendaBarangTemp',
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

        if (!$dataDb) {
            abort(404, 'Data pengadaan tidak ditemukan di database.');
        }

        // 3. Opsi Keamanan: Hanya pemohon atau pimpinan yang bisa lihat
        if (Auth::id() !== $dataDb->id_pemohon && Auth::user()->hak_akses !== 'pimpinan') {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat surat ini.');
        }

        // 5. Tentukan status Approved (Watermark akan hilang jika status 'setuju')
        $is_approved = ($dataDb->status_perawatan === 'disetujui');

        // 6. Siapkan data untuk dikirim ke View Blade
        $data = [
            'nomor_surat'     => $dataDb->id_perawatan,
            'nama_barang'     => $dataDb->nama_item == null ?  $dataDb->nama_room :  $dataDb->nama_item,
            'qty'             => $dataDb->qty_perawatan == null ? 'Ruangan' : $dataDb->qty_perawatan,
            'tahun_akademik'  => $dataDb->tahun_akademik,
            'keperluan_prodi' => $dataDb->keperluan_prodi,
            'dekan'           => $dataDb->nama ?? 'Nama Belum Diatur',
            'nidn'            => $dataDb->id_user ?? '-',
            'is_approved'     => $is_approved, // Variabel penting untuk Watermark & TTD
            'verif_url'       => url('/verifikasi/surat/' . $id), // URL untuk QR Code
            'kategori'        => $dataDb->nama_item == null ? 'prasarana' : 'sarana',
        ];

        // 7. Render ulang PDF agar tampilan selalu update sesuai status terbaru di DB
        $pdf = Pdf::loadView('surat_perawatan', $data);

        // 8. Bersihkan nama file dari karakter '/' agar tidak error saat di-stream
        $namaFileAman = str_replace(['/', '\\'], '-', $nomorSuratAsli);

        // 9. Tampilkan PDF ke browser
        return $pdf->stream('Surat_Perawatan_' . $namaFileAman . '.pdf');
    }

    public function downloadSuratPerawatan()
    {
        dd('surat download');
    }

    public function ajukanPerawatan()
    {
        dd('simpan pengajuan perawatan');
    }
}
