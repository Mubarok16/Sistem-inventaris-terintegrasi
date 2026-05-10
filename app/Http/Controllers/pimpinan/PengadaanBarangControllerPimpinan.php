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
}
