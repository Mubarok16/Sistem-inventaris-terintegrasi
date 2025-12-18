<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\DataRuangan;
use App\Models\UsageRooms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class peminjamanRuanganController extends Controller
{
    // halaman detail peminjaman ruangan
    // ke halaman detail pengajuan peminjaman
    public function DetailPeminjamanRuangan($id)
    {
        // mengambil tgl chosed dari session 
        $tgl_chosed = session()->get('tgl_chosed_room');
        // membuat var tgl table jadwal penggunaan barang
        $tglForTblUsageRuang = null;

        // jika tgl chosed null maka tgl = tgl sekarang
        if ($tgl_chosed === null) {
            $tglForTblUsageRuang = now()->format('Y-m-d');
        } else {
            $tglForTblUsageRuang = $tgl_chosed;
        }

        // mengambil detail barang berdasarkan id_item
        $detailRuangan = DataRuangan::where('id_room', $id)
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('rooms.*', 'tipe_rooms.nama_tipe_room')
            ->get();

        // mengambil data penggunaan barang berdasarkan id_item dan tgl input sekarang
        $dataUsageRooms = UsageRooms::where('id_room', $id)
            ->leftjoin('agenda_fakultas', 'agenda_fakultas.kode_agenda', '=', 'usage_rooms.kode_agenda')
            ->leftjoin('peminjaman', 'peminjaman.kode_peminjaman', '=', 'usage_rooms.kode_peminjaman')
            ->select(
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.tgl_kembali_usage_room',
                'usage_rooms.status_usage_room',
                'agenda_fakultas.nama_agenda',
                'peminjaman.ket_peminjaman',
            )
            ->wheredate('tgl_pinjam_usage_room', '=', $tglForTblUsageRuang)
            ->where('status_usage_room', '!=', 'selesai')
            ->where('status_usage_room', '!=', 'ditolak')
            ->orderBy('tgl_pinjam_usage_room', 'asc')
            ->get();

        $id_room = $id;
        // dd($dataUsageRooms);
        $user = Auth::guard('peminjam')->user()->nama_peminjam;
        $halaman = 'contentDetailPeminjamanRuangan';
        return view('Page_mhs.dashboardMhs', compact('halaman', 'user', 'detailRuangan', 'dataUsageRooms', 'id_room', 'tglForTblUsageRuang'));
    }

    // menyimpan data ruangan ke cart
    public function RuanganAddCart(Request $request)
    {
        // mengambil id_room dan tgl chosed
        $request->validate([
            'id_room' => 'required',
        ]);

        // mengambil nama ruangan berdasarkan id yg diinput
        $dataRuanganDb = DataRuangan::where('id_room', $request->id_room)
            ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
            ->select('rooms.nama_room', 'rooms.gambar_room', 'tipe_rooms.nama_tipe_room')
            ->get();

        // cek apakah session cart_barang sudah ada isinya atau tidak
        if (session()->get('cart_ruangan') === null) {

            // menyimpan data input peminjaman ruangan ke list peminjaman 
            session()->put('cart_ruangan', [
                [
                    'id_room' => $request->id_room,
                    'nama_room' => $dataRuanganDb[0]->nama_room,
                    'nama_tipe_room' => $dataRuanganDb[0]->nama_tipe_room,
                    'gambar_room' => $dataRuanganDb[0]->gambar_room,
                ]
            ]);

        } else {
            // menyimpan data input peminjaman ruangan ke list peminjaman
            // jika di session cart_barang sudah ada data, data baru akan ditambahkan setelahnya
            $cartBarang = session()->get('cart_ruangan', []);

            // jika data dengan id yg diinput sudah ada maka gagal
            foreach ($cartBarang as $value) {
                if ($value['id_room'] === $request->id_room) {
                    return back()->with('gagal', 'ruangan sudah ada di cart peminjaman!');
                }
            }

            $cartBarangbaru =
                [
                    'id_room' => $request->id_room,
                    'nama_room' => $dataRuanganDb[0]->nama_room,
                    'nama_tipe_room' => $dataRuanganDb[0]->nama_tipe_room,
                    'gambar_room' => $dataRuanganDb[0]->gambar_room,
                ];

            session()->push('cart_ruangan', $cartBarangbaru);
        }

        // kembali ke halaman detail peminjaman barang
        return back()->with('success', 'barang berhasil ditambahkan ke cart peminjaman!');
    }
}
