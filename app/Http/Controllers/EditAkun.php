<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class EditAkun extends Controller
{
    public function EditAkunUser(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'max:12',
                'hak_akses' => 'required|string',
            ]);

            if (User::where('username', $request->username)->count() > 1) {
                return redirect()->back()->with('gagal', 'username dan password sudah digunakan, silakan gunakan username lain!');
            }

            $User = User::where('id_user', $id)->firstOrFail();

            if ($request->password === null) {
                $User->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'hak_akses' => $request->hak_akses,
                    'updated_at' => now(),
                ]);
            } else {
                $User->update([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'hak_akses' => $request->hak_akses,
                    'updated_at' => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Akun ' . $User->nama . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal diperbarui!');
        }
    }

    public function EditAkunPeminjam(Request $request, $id)
    {
        try {
            $request->validate([
                'nama_peminjam' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'max:12',
                'prodi' => 'required|string',
            ]);

            if (Peminjam::where('username', $request->username)->count() > 1) {
                return redirect()->back()->with('gagal', 'username dan password sudah digunakan, silakan gunakan username lain!');
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
                $peminjam = Peminjam::where('no_identitas', $id)->firstOrFail();
                $peminjam->update([
                    'nama_peminjam' => $request->nama_peminjam,
                    'username' => $request->username,
                    'fakultas' => $fakultas,
                    'prodi' => $request->prodi,
                    'updated_at' => now(),
                ]);
            } else {
                $peminjam = Peminjam::where('no_identitas', $id)->firstOrFail();
                $peminjam->update([
                    'nama_peminjam' => $request->nama_peminjam,
                    'username' => $request->username,
                    'password' => Hash::make($request->password),
                    'fakultas' => $fakultas,
                    'prodi' => $request->prodi,
                    'updated_at' => now(),
                ]);
            }


            return redirect()->back()->with('success', 'Akun ' . $request->nama_peminjam . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            // return redirect()->back()->with('gagal', 'Akun gagal diperbarui!');
            dd('Error saat update:', $e->getMessage());
        }
    }
}
