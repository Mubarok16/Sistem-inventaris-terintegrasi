<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengelolaanPeminjamanAdmin extends Controller
{
    // menampilkan halaman detail peminjaman admin
    function DetailPeminjamanAdmin($id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $dataDetailPengajuanPeminjaman = DB::table('peminjaman')
            ->join('peminjam', 'peminjaman.no_identitas', '=', 'peminjam.no_identitas')
            ->join('users', 'peminjaman.id_user', '=', 'users.id_user')
            ->select('peminjaman.*', 'peminjam.nama_peminjam', 'users.nama') // Pilih kolom yang diperlukan
            ->where('peminjaman.kode_peminjaman', $id)
            ->get();

        $dataDetailPengajuanPeminjamanBarang = DB::table('usage_items')
            ->join('items', 'usage_items.id_item', '=', 'items.id_item')
            ->select('usage_items.*', 'items.nama_item') // Pilih kolom yang diperlukan
            ->where('usage_items.kode_peminjaman', $id)
            ->get();

        $dataDetailPengajuanPeminjamanRuangan = DB::table('usage_rooms')
            ->join('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->select('usage_rooms.*', 'rooms.nama_room') // Pilih kolom yang diperlukan
            ->where('usage_rooms.kode_peminjaman', $id)
            ->get();

        // dd($dataDetailPengajuanPeminjamanBarang);

        $user = Auth::user()->nama;
        $halaman = 'contentDetailPenminjaman';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataDetailPengajuanPeminjaman', 'dataDetailPengajuanPeminjamanBarang', 'dataDetailPengajuanPeminjamanRuangan'));
    }

    function persetujuan(Request $request)
    {
        $request->validate([
            'kode_peminjaman' => 'string',
        ]);

        DB::table('peminjaman')
            ->where('kode_peminjaman', $request->kode_peminjaman)
            ->update(['status_peminjaman' => 'belum diambil', 'updated_at' => now()]);

        // $getdata = DB::table('usage_items')
        //     ->select('usage_items.id_item')
        //     ->where('kode_peminjaman', $request->kode_peminjaman)
        //     ->get();

        // foreach ($getdata as $kode) {
        //     DB::table('usage_items')
        //         ->where('kode_peminjaman', $request->kode_peminjaman)
        //         ->where('id_item', $kode->id_item)
        //         ->update(['status_usage_item' => 'disetujui', 'updated_at' => now()]);
        // }

        return redirect()->route('admin.pengajuan.peminjaman')->with('success', 'Status persetujuan berhasil diperbarui.');
    }
}
