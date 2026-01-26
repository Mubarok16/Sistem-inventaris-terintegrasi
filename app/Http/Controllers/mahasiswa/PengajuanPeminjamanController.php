<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\UsageItems;
use App\Models\UsageRooms;
use Illuminate\Support\Facades\Storage;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Symfony\Component\Clock\now;

class PengajuanPeminjamanController extends Controller
{
    // menampilkan halaman detail transaksi peminjaman mahasiswa
    public function mahasiswaDetailTransaksi()
    {
        $user = auth()->guard('peminjam')->user()->nama_peminjam;
        $no_identitas = auth()->guard('peminjam')->user()->no_identitas;
        $halaman = 'contentDetailTransaksiPeminjamanMhs';
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'no_identitas'));
    }

    // proses pengajuan peminjaman
    public function PengajuanPeminjaman(Request $request)
    {
        // mengambil data dari input request
        $nama_kegiatan = $request->input('nama_kegiatan');
        $id_peminjam = $request->input('id_peminjam');
        $tgl_pinjam = $request->input('tgl_pinjam');
        $tgl_kembali = $request->input('tgl_kembali');
        $lampiran_file = $request->file('lampiran_file');
        $jam_mulai = $request->input('jam_mulai');
        $jam_selesai = $request->input('jam_selesai');
        $repeat = $request->input('repeat');

        // mengambil data cart dari session
        $cartBarang = session()->get('cart');
        $cartRuangan = session()->get('cart_ruangan');

        // mengecek apakah cart barang atau ruangan ada isinya
        if (!$cartBarang && !$cartRuangan) {
            return redirect()->back()->with('gagal', 'Tidak ada barang atau ruangan yang dipilih untuk diajukan peminjaman.');
        }

        // mengubah inputan tgl pinjam menjadi carbon
        $tglPinjamCarbon = Carbon::parse($tgl_pinjam . '00:00:00');
        $tglKembaliCarbon = Carbon::parse($tgl_kembali . '23:59:59');

        //jam mulai dan jam selesai digunakan hanya untuk opsi spesifik
        $jamMulai = null;
        $jamSelesai = null;

        // cek apakah jam mulai dan jam selesai ada
        if ($jam_mulai != null && $jam_selesai != null) {
            $jamMulai = $jam_mulai;
            $jamSelesai = $jam_selesai;
        }

        // Tentukan Rentang Tanggal
        $period = CarbonPeriod::create($request->tgl_pinjam, $request->tgl_kembali);

        // proses penyimpanan pengajuan peminjaman ke database
        $kode_peminjaman = Str::random(12);

        // menyimpan file lampiran ke folder private/lampiran_file
        $path = $request->file('lampiran_file')->store('lampiran_file', 'local');

        //menyimpan data peminjaman ke database
        DB::table('peminjaman')->insert([
            'kode_peminjaman' => $kode_peminjaman, // kode_peminjaman
            'no_identitas' => $id_peminjam,
            'id_user' => null, // id_user
            'ket_peminjaman' => $nama_kegiatan,
            'lampiran_file' => $path,
            'tgl_tansaksi' => Carbon::now(), // tgl_transaksi
            'created_at' => Carbon::now(), // dibuat pada
            'updated_at' => Carbon::now(), // diupdate pada
            'status_peminjaman' => 'diajukan', // status_peminjaman
            'tgl_pinjam' => $tglPinjamCarbon,
            'tgl_kembali' => $tglKembaliCarbon,
        ]);

        // jika jam mulai dan jam selesai ada maka peminjaman itu kategori spesifik
        // if ($jam_mulai != null && $jam_selesai != null) {

        // Array untuk Insert Usage Room 
        $dataRoom = [];
        if ($cartRuangan != null) {
            foreach ($cartRuangan as $ruangan) { // Loop untuk jika meminjam banyak ruangan Ruangan
                foreach ($period as $date) {       // Loop untuk Tanggal per Hari
                    $dataRoom[] = [
                        'kode_peminjaman' => $kode_peminjaman,
                        'kode_agenda' => NULL,
                        'id_room' => $ruangan['id_room'],
                        'tgl_pinjam_usage_room' => $date->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                        'tgl_kembali_usage_room' => $date->setTime(23, 0, 0)->format('Y-m-d H:i:s'),
                        'status_usage_room' => 'diajukan',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'jam_mulai_usage_room' => $jamMulai,
                        'jam_selesai_usage_room' => $jamSelesai,
                    ];
                }
            }
        }

        // Array untuk Insert Usage Item
        $dataItem = [];
        if ($cartBarang != null) {
            foreach ($cartBarang as $barang) {
                foreach ($period as $date) {
                    $dataItem[] = [
                        'kode_peminjaman' => $kode_peminjaman,
                        'kode_agenda' => NULL,
                        'id_item' => $barang['id_item'],
                        'qty_usage_item' => $barang['qty_pinjam'],
                        'tgl_pinjam_usage_item' => $date->setTime(0, 0, 0)->format('Y-m-d H:i:s'),
                        'tgl_kembali_usage_item' => $date->setTime(23, 0, 0)->format('Y-m-d H:i:s'),
                        'status_usage_item' => 'diajukan',
                        'created_at' => now(),
                        'updated_at' => now(),
                        'jam_mulai_usage_item' => $jamMulai,
                        'jam_selesai_usage_item' => $jamSelesai,
                    ];
                }
            }
        }

        // Melakukan Insert ke Database usage_room
        if ($dataRoom != null) {
            DB::table('usage_rooms')->insert($dataRoom);
        }
        // Melakukan Insert ke Database usage_item
        if ($dataItem != null) {
            DB::table('usage_items')->insert($dataItem);
        }

        // } else { // jika jam mulai dan jam selesai tidak ada maka peminjaman itu kategori full day

        //     // loop untuk menyimpan lebih dari 1 brang yg dinputkan dari array input barang di session
        //     if ($cartBarang != null) {
        //         foreach ($cartBarang as $barang) {
        //             //simpan barang ke db usage_barang
        //             UsageItems::create([
        //                 'kode_peminjaman' => $kode_peminjaman,
        //                 'kode_agenda' => NULL,
        //                 'id_item' => $barang['id_item'],
        //                 'qty_usage_item' => $barang['qty_pinjam'],
        //                 'tgl_pinjam_usage_item' => $tglPinjamCarbon,
        //                 'tgl_kembali_usage_item' => $tglKembaliCarbon,
        //                 'status_usage_item' => 'diajukan',
        //                 'created_at' => now(),
        //                 'updated_at' => now(),
        //                 'jam_mulai_usage_item' => $jamMulai,
        //                 'jam_selesai_usage_item' => $jamSelesai,
        //             ]);
        //         }
        //     }

        //     // loop untuk menyimpan lebih dari 1 ruangan yg dinputkan dari array input barang di session
        //     if ($cartRuangan != null) {
        //         foreach ($cartRuangan as $ruangan) {
        //             //simpan barang ke db usage_barang
        //             UsageRooms::create([
        //                 'kode_peminjaman' => $kode_peminjaman,
        //                 'kode_agenda' => NULL,
        //                 'id_room' => $ruangan['id_room'],
        //                 'tgl_pinjam_usage_room' => $tglPinjamCarbon,
        //                 'tgl_kembali_usage_room' => $tglKembaliCarbon,
        //                 'status_usage_room' => 'diajukan',
        //                 'created_at' => now(),
        //                 'updated_at' => now(),
        //                 'jam_mulai_usage_room' => $jamMulai,
        //                 'jam_selesai_usage_room' => $jamSelesai,
        //             ]);
        //         }
        //     }
        // }

        // menghapus session cart setelah pengajuan peminjaman berhasil
        session()->forget('cart');
        session()->forget('cart_ruangan');

        // redirect ke halaman list peminjaman dengan pesan sukses
        return redirect()->route('mhs-list-peminjaman')->with('success', 'Berhasil mengajukan peminjaman!');
    }
}
