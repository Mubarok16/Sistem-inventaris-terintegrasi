<?php

namespace App\Http\Controllers;

use App\Models\TipeRuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengelolaanRuangan extends Controller
{
    public function simpanTipeRuangan(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama_tipe' => 'required|string|max:255',
            ]);

            // do {
            //     // Buat ID acak baru
            //     $id_tipe_acak = Str::random(12);

            //     // Cek apakah ID ini sudah ada di database
            //     $idSudahAda = TipeRuangan::where('id_tipe_room', $id_tipe_acak)->exists();
            // } while ($idSudahAda);

            $TipeRuangan = new TipeRuangan();// instance untuk mengakses method model

            $idSingkat = $TipeRuangan->getSingkatanAttribute($request->nama_tipe);// memanggil method getSingkatanAttribute dari model TipeRuangan

            // Simpan tipe ruangan ke database
            TipeRuangan::create([
                'id_tipe_room' => $idSingkat,
                'nama_tipe_room' => $request->nama_tipe,
            ]);
            return redirect()->back()->with('success', 'Tipe ruangan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan tipe ruangan' . $e->getMessage());
        }
    }

    public function editTipeRuangan(Request $request, $id)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama_tipe' => 'required',
            ]);

            if (TipeRuangan::where('nama_tipe_room', $request->nama_tipe)->count() > 0) {
                return redirect()->back()->with('gagal', 'silakan gunakan nama tipe lain!');
            }

            TipeRuangan::where('id_tipe_room', $id)->update([
                'nama_tipe_room' => $request->nama_tipe,
            ]);
            // dd($id);

            // Simpan tipe ruangan ke database

            return redirect()->back()->with('success', 'Tipe ruangan berhasil di edit.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan tipe ruangan' . $e->getMessage());
        }
    }

    public function hapusTipeRuangan(Request $request, $id)
    {
         try {
            $request->validate([
                'id_tipe' => 'required',
            ]);

            // dd($request->all());

            $TipeRuangan= TipeRuangan::where('id_tipe_room', $request->id_tipe)->first();
            $TipeRuangan->delete();

            return redirect()->back()->with('success', 'Tipe berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }
    }

    
}
