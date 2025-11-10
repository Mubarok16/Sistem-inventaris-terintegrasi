<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAkun extends Controller
{
    public function showCreateAkunFormPeminjam()
    {
        return view('BuatAkun'); // retun menampilkan view login.blade.php
        // }
    }

    public function SimpanAkunPeminjam(Request $request)
    {
        try {
            $request->validate([
                'no_identitas' => 'required|integer|unique:peminjam,no_identitas',
                'nama_peminjam' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:peminjam,username',
                'password' => 'required|string|max:12',
                // 'fakultas' => 'required|string',
                'prodi' => 'required|string',
                'img_identitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Simpan file gambar jika diupload
            $imgPath = null;
            if ($request->hasFile('img_identitas')) {
                $imgPath = $request->file('img_identitas')->store('uploads/identitas', 'public');
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
            // Simpan data ke database
            Peminjam::create([
                'no_identitas' => $request->no_identitas,
                'nama_peminjam' => $request->nama_peminjam,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'fakultas' => $fakultas,
                'prodi' => $request->prodi,
                'img_identitas' => $imgPath,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->intended('/create-akun-peminjam')->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal dibuat!');
            // dd('Error saat update:', $e->getMessage());

        }
    }

    // ------------------------ tambah akun admin (staff sarpras) ------------------------

    public function SimpanAkunAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:8',
            // 'hak_akses' => 'required|string',
        ]);

        // dd($request->all());

        do {
            // 2. Buat ID acak baru
            $id_user_acak = Str::random(12);

            // 3. Cek apakah ID ini sudah ada di database
            $idSudahAda = User::where('id_user', $id_user_acak)->exists();
        } while ($idSudahAda);

        // dd($id_user_acak);
        User::create([
            'id_user' => $id_user_acak,
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'hak_akses' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Akun admin berhasil dibuat!');
    }
}
