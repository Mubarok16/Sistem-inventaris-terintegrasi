<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EditAkun extends Controller
{
    // page edit akun
    public function editAkun($id)
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        // mengamil data peminjam by id
        $dataPeminjam = DB::table('peminjam')
            ->where('no_identitas', '=', $id)
            ->first();

        // mengambil data user
        $dataUser = DB::table('users')
            ->where('id_user', '=', $id)
            ->first();

        // dd($dataPeminjam, $dataUser);
        $JmlhAdmin = User::where('hak_akses', 'admin')->count();
        $user = Auth::user()->nama;
        $halaman = 'contentEditUser';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'dataUser', 'dataPeminjam', 'JmlhAdmin'));
    }

    // edit akun pimpinan dan admin
    public function EditAkunUser(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'max:12',
                'role' => 'required|string',
                'no_hp' => 'required'
            ]);

            if (User::where('username', $request->username)->count() > 1) {
                return redirect()->back()->with('gagal', 'username dan password sudah digunakan, silakan gunakan username lain!');
            }

            $User = User::where('id_user', $id)->firstOrFail();

            if ($request->input('status') != null) {
                $User->update([
                    'status' => $request->input('status'),
                ]);
            }

            if ($request->password === null) {
                $User->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'hak_akses' => $request->role,
                    'no_hp' => $request->no_hp,
                    'updated_at' => now(),
                ]);
            } else {
                $User->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'hak_akses' => $request->role,
                    'no_hp' => $request->no_hp,
                    'updated_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Akun ' . $User->nama . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal diperbarui!');
        }
    }

    // update akun peminjam
    public function EditAkunPeminjam(Request $request, $id)
    {
        // dd($request->all());
        try {
            $request->validate([
                'nama_peminjam' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'max:12',
                'prodi' => 'required|string',
            ]);

            // cek apakah username sudah ada di db
            if (Peminjam::where('username', $request->username)->count() > 1) {
                return redirect()->back()->with('gagal', 'username dan password sudah digunakan, silakan gunakan username lain!');
            }

            // ambil data peminjam by id atau no_identitas
            $mahasiswa = DB::table('peminjam')->where('no_identitas', $id)->first();
            // Cek apakah user punya foto dan file-nya benar-benar ada di storage
            if ($request->hasFile('img_identitas')) {

                // Hapus foto lama jika ada (agar storage tidak penuh)
                if ($mahasiswa->img_identitas && Storage::disk('public')->exists($mahasiswa->img_identitas)) {
                    Storage::disk('public')->delete($mahasiswa->img_identitas);
                }

                // Simpan file baru ke folder 'identitas' di disk 'public'
                $path = $request->file('img_identitas')->store('uploads/identitas', 'public');

                // update gambar ke db
                DB::table('peminjam')
                    ->where('no_identitas', $id)
                    ->update([
                        'img_identitas' => $path,
                    ]);
            }

            $fakultas = '';
            if ($request->prodi === 'teknik sipil' or $request->prodi === 'teknik komputer') {
                $fakultas = 'teknik';
            } elseif ($request->prodi === 'ilmu hukum') {
                $fakultas = 'hukum';
            } elseif ($request->prodi === 'manajemen') {
                $fakultas = 'ekonomi';
            } elseif ($request->prodi === 'pendidikan bahasa inggris' or $request->prodi === 'pendidikan bahasa indonesia' or $request->prodi === 'pendidikan matematika' or $request->prodi === 'pendidikan biologi') {
                $fakultas = 'keguruan dan ilmu pendidikan';
            } elseif ($request->prodi === 'ilmu politik') {
                $fakultas = 'ilmu sosial dan politik';
            } elseif ($request->prodi === 'pendidikan agama islam' or $request->prodi === 'ekonomi syariah' or $request->prodi === 'bimbingan konseling islam') {
                $fakultas = 'agama islam';
            } elseif ($request->prodi === 'agribisnis' or $request->prodi === 'agroteknologi') {
                $fakultas = 'pertanian';
            } elseif ($request->prodi === 'kesehatan masyarakat') {
                $fakultas = 'kesehatan masyarakat';
            }

            if ($request->password === null) {
                // $peminjam = Peminjam::where('no_identitas', $id)->firstOrFail();
                $update = [
                    'nama_peminjam' => $request->nama_peminjam,
                    'username' => $request->username,
                    'fakultas' => $fakultas,
                    'prodi' => $request->prodi,
                    'tahun_masuk' => $request->tahun_masuk,
                    'status' => $request->status,
                    'updated_at' => now(),
                ];
            } else {
                // $peminjam = Peminjam::where('no_identitas', $id)->firstOrFail();
                $update = [
                    'nama_peminjam' => $request->nama_peminjam,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'fakultas' => $fakultas,
                    'prodi' => $request->prodi,
                    'tahun_masuk' => $request->tahun_masuk,
                    'status' => $request->status,
                    'updated_at' => now(),
                ];
            }

            // Update ke Database
            DB::table('peminjam')
                ->where('no_identitas', $id)
                ->update($update);


            return redirect()->back()->with('success', 'Akun ' . $request->nama_peminjam . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal diperbarui!');
        }
    }
}
