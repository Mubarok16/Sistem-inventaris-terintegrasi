<?php

namespace App\Http\Controllers\pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class PengadaanBarangControllerPimpinan extends Controller
{

    public function PagePengadaanBarang(Request $request)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        $pengadaan = DB::table('pengadaan_barang')
            ->join('users', 'users.id_user', '=', 'pengadaan_barang.id_pemohon')
            ->select('pengadaan_barang.*', 'users.nama as nama_pemohon')
            ->get();

        // dd($pengadaan);

        $user = Auth::user()->nama;
        $halaman = 'contentPengadaanBarang';
        return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user', 'pengadaan'));
    }

    // acc pengadaan barang
    public function signSurat(Request $request, $id)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        try {
            $id_decoded = base64_decode($id);

            $updated = DB::table('pengadaan_barang')
                ->where('id_pengadaan', $id_decoded)
                ->update([
                    'status_pengadaan' => 'disetujui',
                    'updated_at'       => now(),
                    'id_penyetuju'     => Auth::user()->id_user
                ]);

            return redirect()->back()->with('succes', 'Tidak ada perubahan data.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan sistem, silakan coba lagi.' . $e);
        }


        // dd($pengadaan);
    }

    // tolak pengadaan barang
    public function tolakSuratPengadaan(Request $request, $id)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        try {
            $id_decoded = base64_decode($id);

            $updated = DB::table('pengadaan_barang')
                ->where('id_pengadaan', $id_decoded)
                ->update([
                    'status_pengadaan' => 'ditolak',
                    'updated_at'       => now(),
                    'id_penyetuju'     => Auth::user()->id_user
                ]);

            return redirect()->back()->with('succes', 'Tidak ada perubahan data.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan sistem, silakan coba lagi.' . $e);
        }


        // dd($pengadaan);
    }


    // perawatan barang

    // page perawatan barang 
    public function PagePerawatanBarang(Request $request)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        $perawatan = DB::table('perawatan_barang')
            ->join('users', 'users.id_user', '=', 'perawatan_barang.id_pemohon')
            ->leftJoin('items', 'items.id_item', '=', 'perawatan_barang.id_item')
            ->leftJoin('rooms', 'rooms.id_room', '=', 'perawatan_barang.id_room')
            ->select(
                'perawatan_barang.*',
                'users.nama as nama_pemohon',
                'items.nama_item',
                'items.merek_model',
                'rooms.nama_room',
            )
            ->get();

        // dd($perawatan);

        $user = Auth::user()->nama;
        $halaman = 'contentPerawatanBarang';
        return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user', 'perawatan'));
    }

    // acc surat perawatan
    public function signSuratPerawatan($id)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        try {
            $id_decoded = base64_decode($id);

            $updated = DB::table('perawatan_barang')
                ->where('id_perawatan', $id_decoded)
                ->update([
                    'status_perawatan' => 'disetujui',
                    'updated_at'       => now(),
                    'id_penyetuju'     => Auth::user()->id_user
                ]);

            return redirect()->back()->with('succes', 'Tidak ada perubahan data.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan sistem, silakan coba lagi.' . $e);
        }
    }

    // tolak surat perawatan
    public function tolakSuratPerawatan($id)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        try {
            $id_decoded = base64_decode($id);

            $perawatan = DB::table('perawatan_barang')
                ->where('id_perawatan', $id_decoded)
                ->first();

            $item = DB::table('items')
                ->where('id_item', $perawatan->id_item)
                ->first();

            // dd('berhasil');

            if ($perawatan->id_item != null) {
                // dd('item');
                DB::table('items')
                    ->where('id_item', $perawatan->id_item)
                    ->update([
                        'kondisi_item' => 'Baik',
                        'qty_item' => $perawatan->qty_perawatan + $item->qty_item,
                        'updated_at' => now(),
                    ]);

                DB::table('perawatan_barang')
                    ->where('id_perawatan', $id_decoded)
                    ->update([
                        'status_perawatan' => 'ditolak',
                        'updated_at'       => now(),
                        'id_penyetuju'     => Auth::user()->id_user
                    ]);

                return redirect()->back()->with('succes', 'Pengajuan Ditolak');
            } else {
                // dd('rooms');
                DB::table('rooms')
                    ->where('id_room', $perawatan->id_room)
                    ->update([
                        'kondisi_room' => 'Baik',
                        'updated_at' => now(),
                    ]);
                DB::table('perawatan_barang')
                    ->where('id_perawatan', $id_decoded)
                    ->update([
                        'status_perawatan' => 'ditolak',
                        'updated_at'       => now(),
                        'id_penyetuju'     => Auth::user()->id_user
                    ]);
                return redirect()->back()->with('succes', 'Pengajuan Ditolak');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan sistem, silakan coba lagi.' . $e);
        }
    }
}
