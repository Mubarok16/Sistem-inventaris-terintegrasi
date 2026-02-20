<?php

namespace App\Http\Controllers;

use App\Models\TipeRuangan;
use App\Models\DataRuangan;
use Illuminate\Support\Facades\Auth;
use Dflydev\DotAccessData\Data;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class PengelolaanRuangan extends Controller
{
    public function simpanTipeRuangan(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama_tipe' => 'required|string|max:255',
            ]);

            //cek apakah nama tipe ruangan sudah ada
            if (TipeRuangan::where('nama_tipe_room', $request->nama_tipe)->count() > 0) {
                return redirect()->back()->with('gagal', 'nama tipe ruangan sudah digunakan, silakan gunakan nama tipe lain!');
            }

            $TipeRuangan = new TipeRuangan(); // instance untuk mengakses method model
            $idSingkat = $TipeRuangan->getSingkatanAttribute($request->nama_tipe); // memanggil method getSingkatanAttribute dari model TipeRuangan

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
            // $request->validate([
            //     'id_tipe' => 'required',
            // ]);

            // dd($request->all());

            $TipeRuangan = TipeRuangan::where('id_tipe_room', $id)->first();
            $TipeRuangan->delete();

            return redirect()->back()->with('success', 'Tipe berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }
    }

    // fungsi untuk menambah ruangan baru =============================================================

    public function tambahRuangan(Request $request)
    {
        try {
            $request->validate([
                'nama_room' => 'required',
                'tipe' => 'required',
                'kondisi' => 'required',
                'gambar_room' => 'required',
            ]);

            //cek apakah nama ruangan sudah ada
            if (DataRuangan::where('nama_room', $request->nama_room)->count() > 0) {
                return redirect()->back()->with('gagal', 'nama ruangan sudah digunakan, silakan gunakan nama ruangan lain!');
            }

            // mengambil data urutan
            $Urutan = DB::table('rooms')
                ->join('tipe_rooms', 'rooms.id_tipe_room', '=', 'tipe_rooms.id_tipe_room')
                ->select('rooms.*', 'tipe_rooms.nama_tipe_room') // Pilih kolom yang diperlukan
                ->where('rooms.id_tipe_room', '=', $request->tipe)
                ->latest()
                ->count();

            $DataRuangan = new DataRuangan(); // instance untuk mengakses method model
            $idroom_singkat = $DataRuangan->getSingkatanNamaRoom($request->nama_room, $request->tipe, $Urutan); // memanggil method getSingkatanNamaRoom dari model DataRuangan

            $imgPath = null;
            if ($request->hasFile('gambar_room')) {
                $imgPath = $request->file('gambar_room')->store('uploads/ruangan', 'public');
            }

            // dd($idroom_singkat);
            DataRuangan::create([
                'id_room' => $idroom_singkat,
                'id_tipe_room' => $request->tipe,
                'nama_room' => $request->nama_room,
                'kondisi_room' => $request->kondisi,
                'gambar_room' => $imgPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Data Ruangan berhasil di tambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }
    }

    public function hapusRuangan($id)
    {
        try {
            // $request->validate([
            //     'id_tipe' => 'required',
            // ]);

            // dd($request->all());


            $DataRuangan = DataRuangan::where('id_room', $id)->first();

            $path = 'public/' . $DataRuangan->gambar_room;


            Storage::delete($path);

            $DataRuangan->delete();

            return redirect()->back()->with('success', 'Ruangan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }
    }

    public function DetailRuangan(Request $request, $id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $DataRuangan = DataRuangan::where('id_room', $id)
            ->get();

        $tipeRuangan = TipeRuangan::get();

        $dataBarangYgDruangan = DB::table('items')
            ->join('tipe_item', 'items.id_tipe_item', '=', 'tipe_item.id_tipe_item')
            ->where('items.id_room', '=', $id)
            ->select(
                'items.id_item',
                'items.nama_item',
                'items.img_item',
                'items.qty_item',
                'tipe_item.nama_tipe_item'
            )
            ->get();

        // session(['dataRuangTemp' => $DataRuangan]);
        // session(['dataBarangYgDruangan' => $dataBarangYgDruangan]);

        // dd($DataRuangan);

        $user = Auth::user()->nama;
        $halaman = 'contentDetailRuangan';
        return view('Page_admin.dashboard-admin', compact('halaman', 'DataRuangan', 'user', 'tipeRuangan', 'dataBarangYgDruangan'));
    }

    // fungsi untuk edit informasi dasar ruangan
    public function editRuanganInfoDasar(Request $request)
    {
        $DataRuang_lama = DataRuangan::where('nama_room', $request->nama_room)
            ->where('id_tipe_room', $request->tipe_room)
            ->whereNot('id_room', $request->id_room)
            ->count();

        if ($DataRuang_lama > 0) {
            return redirect()->back()->with('gagal', 'Nama ruangan dan tipe ruangan sudah ada!');
        }

        // jika tidak ada gambar baru yang di upload, maka simpan perubahan data ruangan tanpa mengubah gambar
        if (!isset($request->gambar_room)) {
            // simapan perubahan data ruangan tanpa mengubah gambar
            $ruangan = DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'nama_room' => $request->nama_room,
                    'id_tipe_room' => $request->tipe_room,
                    // 'kondisi_room' => $request->kondisi_room,
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'data informasi dasar berhasil diperbarui!');
        } else {

            $gambar_lama = DataRuangan::where('id_room', $request->id_room)
                ->select('gambar_room')
                ->first();

            // dd($gambar_lama['gambar_room']);

            // Cek apakah file ada sebelum dihapus agar tidak error
            if (Storage::disk('public')->exists($gambar_lama['gambar_room'])) {
                Storage::disk('public')->delete($gambar_lama['gambar_room']);
            }

            // ambil path gambar baru dari request
            $file = $request->gambar_room;
            // simpan file baru
            $path = $file->store('uploads/ruangan/', 'public');

            // simpan data ruangan yang sudah di update ke database
            $ruangan = DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'nama_room' => $request->nama_room,
                    'id_tipe_room' => $request->tipe_room,
                    // 'kondisi_room' => $request->kondisi_room,
                    'gambar_room' => $path,
                    'updated_at' => now(),
                ]);
            return redirect()->back()->with('success', 'data informasi dasar berhasil diperbarui!');
        }
    }

    public function editRuanganKondisi(Request $request)
    {
        // dd($request->all());

        if (isset($request->kondisi)) {
            // kondisi diubah menjadi baik
            DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'kondisi_room' => 'Baik',
                    'updated_at' => now(),
                ]);
            return redirect()->back()->with('success', 'data kondisi berhasil diperbarui!');
        } else {
            // kondisi diubah menjadi rusak
            DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'kondisi_room' => 'Rusak',
                    'visibility_room' => '0',
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'data kondisi berhasil diperbarui!');
        }
    }

    public function editRuanganVisibility(Request $request)
    {
        // dd($request->all());

        if (isset($request->visibility)) {

            $kondisi_room = DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->where('kondisi_room', 'Baik')
                ->count();

            // visibility diubah menjadi bisa terlihat, maka kondisi room harus baik
            if ($kondisi_room === 0) {
                return redirect()->back()->with('gagal', 'Ruangan yang rusak tidak dapat diubah menjadi bisa dipinjamkan, silakan ubah kondisi ruangan menjadi baik terlebih dahulu!');
            }

            // kondisi diubah menjadi bisa dipinjamkan
            DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'visibility_room' => '1',
                    'updated_at' => now(),
                ]);
            return redirect()->back()->with('success', 'data visibility berhasil diperbarui!');
        } else {
            // visibility diubah menjadi tidak bisa dipinjamkan
            DB::table('rooms')
                ->where('id_room', $request->id_room)
                ->update([
                    'visibility_room' => '0',
                    'updated_at' => now(),
                ]);

            return redirect()->back()->with('success', 'data visibility berhasil diperbarui!');
        }
    }
}
