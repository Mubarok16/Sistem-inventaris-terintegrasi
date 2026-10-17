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

        if (session()->get('status-pengadaan') === null) {
            $status_pengadaan = 'semua';
        } else {
            $status_pengadaan = session()->get('status-pengadaan');
        }

        $pengadaanBarang = DB::table('pengadaan_barang')
            ->leftjoin('users', 'users.id_user', '=', 'pengadaan_barang.id_pemohon')
            ->leftjoin('detail_staff', 'detail_staff.id_user', '=', 'users.id_user')
            ->leftjoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
            ->select(
                'pengadaan_barang.*',
                DB::raw('COALESCE(detail_staff.nama, detail_dosen.nama) as nama_pemohon')
            )
            ->when($status_pengadaan !== 'semua', function ($query) use ($status_pengadaan) {
                $query->where('pengadaan_barang.status_pengadaan', $status_pengadaan);
            })
            ->orderBy('pengadaan_barang.created_at', 'desc')
            ->paginate(5);

        // dd($pengadaan);

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentPengadaanBarang';
        return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user', 'pengadaanBarang', 'status_pengadaan'));
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

        if (session()->get('status-perawatan') === null) {
            $status_perawatan = 'semua';
        } else {
            $status_perawatan = session()->get('status-perawatan');
        }

        $perawatanBarang = DB::table('perawatan_barang')
            ->leftjoin('users', 'users.id_user', '=', 'perawatan_barang.id_pemohon')
            ->leftjoin('detail_staff', 'detail_staff.id_user', '=', 'users.id_user')
            ->leftjoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
            ->leftJoin('items', 'items.id_item', '=', 'perawatan_barang.id_item')
            ->leftJoin('rooms', 'rooms.id_room', '=', 'perawatan_barang.id_room')
            ->select(
                'perawatan_barang.*',
                DB::raw('COALESCE(detail_staff.nama, detail_dosen.nama) as nama_pemohon'),
                'items.nama_item',
                'items.merek_model',
                'rooms.nama_room',
            )
            ->when($status_perawatan !== 'semua', function ($query) use ($status_perawatan) {
                $query->where('perawatan_barang.status_perawatan', $status_perawatan);
            })
            ->orderBy('perawatan_barang.created_at', 'desc')
            ->paginate(5);

        // dd($perawatan);

        $id_user = Auth::user()->id_user;

        $dosen = DB::table('detail_dosen')
            ->where('id_user', $id_user)
            ->first();

        $user = $dosen->nama;

        $halaman = 'contentPerawatanBarang';
        return view('Page_pimpinan.dahsboardPimpinan', compact('halaman', 'user', 'perawatanBarang', 'status_perawatan'));
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

    // Tolak pengajuan perawatan. Kerusakan hasil pengembalian tidak otomatis kembali menjadi stok tersedia.
    public function tolakSuratPerawatan($id)
    {
        if (Auth::user()->hak_akses !== "pimpinan") {
            abort(403, 'Unauthorized');
        }

        try {
            $id_decoded = base64_decode($id, true);
            if (!$id_decoded) {
                abort(404, 'ID perawatan tidak valid.');
            }

            DB::transaction(function () use ($id_decoded) {
                $perawatan = DB::table('perawatan_barang')
                    ->where('id_perawatan', $id_decoded)
                    ->lockForUpdate()
                    ->first();
                if (!$perawatan) {
                    abort(404, 'Data perawatan tidak ditemukan.');
                }
                if (in_array($perawatan->status_perawatan, ['selesai', 'ditolak'], true)) {
                    return;
                }

                // Pengajuan manual sebelumnya mengurangi stok ketika diajukan, sehingga saat ditolak dikembalikan.
                // Kerusakan dari pengembalian sudah mengurangi stok saat pengembalian dikonfirmasi; jangan ditambah lagi.
                if (($perawatan->sumber_perawatan ?? 'manual') !== 'pengembalian') {
                    if ($perawatan->id_item !== null) {
                        $item = DB::table('items')->where('id_item', $perawatan->id_item)->lockForUpdate()->first();
                        if ($item) {
                            $stokBaru = (int) $item->qty_item + (int) $perawatan->qty_perawatan;
                            DB::table('items')->where('id_item', $perawatan->id_item)->update([
                                'qty_item' => $stokBaru,
                                'kondisi_item' => $stokBaru > 0 ? 'Baik' : $item->kondisi_item,
                                'visibility_item' => $stokBaru > 0 ? '1' : '0',
                                'updated_at' => now(),
                            ]);
                        }
                    } elseif ($perawatan->id_room !== null) {
                        // Ruangan manual yang ditolak dapat dikembalikan ke kondisi tersedia sesuai alur lama.
                        DB::table('rooms')->where('id_room', $perawatan->id_room)->update([
                            'kondisi_room' => 'Baik',
                            'visibility_room' => '1',
                            'updated_at' => now(),
                        ]);
                    }
                }

                DB::table('perawatan_barang')->where('id_perawatan', $id_decoded)->update([
                    'status_perawatan' => 'ditolak',
                    'id_penyetuju' => Auth::user()->id_user,
                    'updated_at' => now(),
                ]);
            });

            return redirect()->back()->with('succes', 'Pengajuan perawatan ditolak. Stok kerusakan pengembalian tetap tidak tersedia.');
        } catch (\Throwable $e) {
            report($e);
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menolak pengajuan perawatan.');
        }
    }
}
