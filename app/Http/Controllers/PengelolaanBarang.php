<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataRuangan;
use App\Models\TipeBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PengelolaanBarang extends Controller
{
    // halaman edit barang ========================================================================
    public function haleditBarang($id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $DataBarang = DB::table('items')->where('id_item', $id)->get();

        // $tipeBarang = TipeBarang::get();
        // dd($DataBarang);
        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentEditBarang';
        return view('Page_admin.dashboard-admin', compact('halaman', 'DataBarang', 'user'));
    }

    // fungsi untuk mengedit informasi dasar barang
    public function editBarangInfoDasar(Request $request)
    {
        // jika tidak ada gambar baru yang di upload, maka simpan perubahan data ruangan tanpa mengubah gambar
        if (!isset($request->gambar_item)) {
            // simapan perubahan data barang tanpa mengubah gambar
            DB::table('items')
                ->where('id_item', $request->id_item)
                ->update([
                    'nama_item' => $request->nama_item,
                    'sumber_perolehan' => $request->sumber_perolehan,
                    'tahun_perolehan' => $request->tahun_perolehan,
                    'merek_model' => $request->merk_model,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'data informasi dasar berhasil diperbarui!');
        } else {

            $gambar_lama = DataBarang::where('id_item', $request->id_item)
                ->select('img_item')
                ->first();

            // dd($gambar_lama['gambar_item']);

            // Cek apakah file ada sebelum dihapus agar tidak error
            if (Storage::disk('public')->exists($gambar_lama['img_item'])) {
                Storage::disk('public')->delete($gambar_lama['img_item']);
            }

            // ambil path gambar baru dari request
            $file = $request->gambar_item;
            // simpan file baru
            $path = $file->store('uploads/barang/', 'public');

            // simpan data barang yang sudah di update ke database
            $ruangan = DB::table('items')
                ->where('id_item', $request->id_item)
                ->update([
                    'nama_item' => $request->nama_item,
                    'merek_model' => $request->merk_model,
                    'sumber_perolehan' => $request->sumber_perolehan,
                    'tahun_perolehan' => $request->tahun_perolehan,
                    // 'kondisi_item' => $request->kondisi_item,
                    'img_item' => $path,
                    'updated_at' => now(),
                ]);
            return redirect()->back()->with('success', 'data informasi dasar berhasil diperbarui!');
        }
    }

    // fungsi untuk mengedit kondisi barang
    public function editBarangKondisi(Request $request)
    {
        // dd($request->all());
        if (isset($request->kondisi)) {
            // kondisi diubah menjadi baik
            DB::table('items')
                ->where('id_item', $request->id_item)
                ->update([
                    'kondisi_item' => 'Baik',
                    'updated_at' => now(),
                ]);
            return redirect()->back()->with('success', 'data kondisi berhasil diperbarui!');
        } else {
            // kondisi diubah menjadi rusak
            DB::table('items')
                ->where('id_item', $request->id_item)
                ->update([
                    'kondisi_item' => 'Rusak',
                    'visibility_item' => '0',
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'data kondisi berhasil diperbarui!');
        }
    }

    // fungsi untuk mengedit visibility barang
    public function editBarangVisibility(Request $request)
    {
        // dd($request->all());
        if (isset($request->visibility)) {

            $kondisi_item = DB::table('items')
                ->where('id_item', $request->id_item)
                ->where('kondisi_item', 'Baik')
                ->count();

            // visibility diubah menjadi bisa terlihat, maka kondisi item harus baik
            if ($kondisi_item === 0) {
                return redirect()->back()->with('gagal', 'Barang yang rusak tidak dapat diubah menjadi bisa dipinjamkan, silakan ubah kondisi barang menjadi baik terlebih dahulu!');
            }

            // kondisi diubah menjadi bisa dipinjamkan
            DB::table('items')
                ->where('id_item', $request->id_item)
                ->update([
                    'visibility_item' => '1',
                    'updated_at' => now(),
                ]);
            return redirect()->back()->with('success', 'data visibility berhasil diperbarui!');
        } else {
            // visibility diubah menjadi tidak bisa dipinjamkan
            DB::table('items')
                ->where('id_item', $request->id_item)
                ->update([
                    'visibility_item' => '0',
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'data visibility berhasil diperbarui!');
        }
    }

    // fungsi untuk menambah tipe barang=====================================================================
    public function simpanTipeBarang(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama_tipe' => 'required',
            ]);

            //cek apakah nama tipe barang sudah ada
            if (\App\Models\TipeBarang::where('nama_tipe_item', $request->nama_tipe)->count() > 0) {
                return redirect()->back()->with('gagal', 'nama tipe barang sudah digunakan, silakan gunakan nama tipe lain!');
            }

            $TipeBarang = new \App\Models\TipeBarang(); // instance untuk mengakses method model
            $idSingkat = $TipeBarang->getSingkatanAttribute($request->nama_tipe); // memanggil method getSingkatanAttribute dari model TipeBarang

            // Simpan tipe barang ke database
            \App\Models\TipeBarang::create([
                'id_tipe_item' => $idSingkat,
                'nama_tipe_item' => $request->nama_tipe,
            ]);
            return redirect()->back()->with('success', 'Tipe barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan tipe barang' . $e->getMessage());
        }
    }
    // fungsi untuk mengedit tipe barang
    public function editTipeBarang(Request $request, $id)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama_tipe' => 'required',
            ]);

            if (\App\Models\TipeBarang::where('nama_tipe_item', $request->nama_tipe)->count() > 0) {
                return redirect()->back()->with('gagal', 'silakan gunakan nama tipe lain!');
            }

            \App\Models\TipeBarang::where('id_tipe_item', $id)->update([
                'nama_tipe_item' => $request->nama_tipe,
            ]);
            // dd($id);
            return redirect()->back()->with('success', 'Tipe barang berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat mengubah tipe barang' . $e->getMessage());
        }
    }
    // fungsi untuk menghapus tipe barang
    public function hapusTipeBarang($id)
    {
        try {
            \App\Models\TipeBarang::where('id_tipe_item', $id)->delete();
            return redirect()->back()->with('success', 'Tipe barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menghapus tipe barang' . $e->getMessage());
        }
    }

    // =====================================================================================================

    // fungsi untuk menambah barang
    public function tambahBarang(Request $request)
    {
        // dd($request->all());/
        try {
            $request->validate([
                'nama_item' => 'required',
                'merek_model' => 'required',
                'kondisi' => 'required',
                'qty' => 'required|integer|min:1',
                'tahun_perolehan' => 'required|integer',
                'gambar_item' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // mengambil data urutan
            $urutan = DB::table('items')
                ->where('nama_item', '=', $request->nama_item)
                ->select('nama_item')
                ->latest()
                ->count();

            $DataBarang = new \App\Models\DataBarang(); // instance untuk mengakses method model
            $idBarang = $DataBarang->generateIdItem($request->nama_item, Str::random(2), $urutan); // memanggil method generateIdItem dari model DataBarang

            // dd($idBarang);
            // upload gambar barang
            $imgPath = null;
            if ($request->hasFile('gambar_item')) {
                $imgPath = $request->file('gambar_item')->store('uploads/barang', 'public');
            }

            // Simpan barang ke database
            DB::table('items')->insert([
                'id_item' => $idBarang,
                'id_room' => $request->tempat_menyimpan,
                // 'id_tipe_item' => $request->tipe,
                'nama_item' => $request->nama_item,
                'merek_model' => $request->merek_model,
                'qty_item' => $request->qty,
                'kondisi_item' => $request->kondisi,
                'sumber_perolehan' => $request->sumber_perolehan ?? null,
                'tahun_perolehan' => $request->tahun_perolehan,
                'img_item' => $imgPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menambahkan barang' . $e->getMessage());
        }
    }

    // fungsi untuk menghapus barang
    public function hapusBarang($id)
    {
        try {
            \App\Models\DataBarang::where('id_item', $id)->delete();
            return redirect()->back()->with('success', 'Barang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Terjadi kesalahan saat menghapus barang' . $e->getMessage());
        }
    }
}
