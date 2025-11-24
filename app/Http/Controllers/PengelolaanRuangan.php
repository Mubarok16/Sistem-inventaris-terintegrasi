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

    public function hapusRuangan(Request $request, $id)
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
        $DataRuangan = DataRuangan::where('id_room', $id)->first();
        $user = Auth::user()->nama;
        $halaman = 'contentDetailRuangan';
        return view('Page_admin.dashboard-admin', compact('halaman','DataRuangan','user'));
        // try {
        //     dd($id);
        //     $DataRuangan = DataRuangan::where('id_room', $id)->first();

        //     // return view('admin.detailRuangan', compact('DataRuangan'));
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('gagal', $e->getMessage());
        // }
    }
}
