<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataRuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PengelolaanBarang extends Controller
{

    public function haleditBarang($id){
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }
        $DataBarang = DataBarang::where('id_item', $id)->first();
        $user = Auth::user()->nama;
        $halaman = 'contentEditBarang';
        return view('Page_admin.dashboard-admin', compact('halaman','DataBarang','user'));
    }

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
        // dd($request->all());
        try {
            $request->validate([
                'nama_item' => 'required',
                'tipe' => 'required',
                'kondisi' => 'required',
                'qty' => 'required|integer|min:1',
                'gambar_item' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // mengambil data urutan
            $urutan = DB::table('items')
                ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
                ->select('items.*', 'tipe_item.nama_tipe_item') // Pilih kolom yang diperlukan
                ->where('items.id_tipe_item', '=', $request->tipe)
                ->latest()
                ->count();

            $DataBarang = new \App\Models\DataBarang(); // instance untuk mengakses method model
            $idBarang = $DataBarang->generateIdItem($request->nama_item, $request->tipe, $urutan); // memanggil method generateIdItem dari model DataBarang

            // dd($idBarang);
            // upload gambar barang
            $imgPath = null;
            if ($request->hasFile('gambar_item')) {
                $imgPath = $request->file('gambar_item')->store('uploads/barang', 'public');
            }

            // Simpan barang ke database
            \App\Models\DataBarang::create([
                'id_item' => $idBarang,
                'id_room' => $request->tempat_menyimpan,
                'id_tipe_item' => $request->tipe,
                'nama_item' => $request->nama_item,
                'merek_model' => "cek",
                'qty_item' => $request->qty,
                'kondisi_item' => $request->kondisi,
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
