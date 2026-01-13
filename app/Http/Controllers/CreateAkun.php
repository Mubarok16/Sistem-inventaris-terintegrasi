<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Contracts\Service\Attribute\Required;

class CreateAkun extends Controller
{
    // page signin akun peminjam
    public function showCreateAkunFormPeminjam()
    {
        return view('BuatAkun'); // retun menampilkan view login.blade.php
        // }
    }

    // simpan akun peminjam ke db dari signin
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

            // cek username sudah ada atau belum
            if (Peminjam::where('username', $request->username)->exists()) {
                return redirect()->back()->with('gagal', 'pastikan username dan password anda unik!, silakan gunakan username lain!');
            }

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
            return redirect()->back()->with('gagal', 'Akun gagal dibuat pastikan anda belum memiliki akun dan npm sesuai!!');
            // dd('Error saat update:', $e->getMessage());

        }
    }

    // simpan akun peminjam (mhs) dari admin
    public function showCreateAkunPeminjamFormAdmin(Request $request)
    {
        // dd($request->file('img_identitas'));
        try {

            $request->validate([
                'no_identitas' => 'required|integer|unique:peminjam,no_identitas',
                'nama_peminjam' => 'required|string|max:100',
                'username' => 'required|string|max:50|unique:peminjam,username',
                'password' => 'required|string|max:12',
                'prodi' => 'required|string',
                'img_identitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => 'required',
                'tahun_masuk' => 'required'
            ]);

            // cek username sudah ada atau belum
            if (Peminjam::where('username', $request->username)->exists()) {
                return redirect()->back()->with('gagal', 'pastikan username dan password anda unik!, silakan gunakan username lain!');
            }

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
                'status' => $request->status,
                'tahun_masuk' => $request->tahun_masuk,
            ]);

            return redirect()->back()->with('success', 'Akun ' . $request->nama . ' berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal dibuat!'.$e);
            // dd('Error saat update:', $e->getMessage());

        }
    }

    // ------------------------ tambah akun admin (staff sarpras) ------------------------

    // page buat akun pengguna dari sisi admin
    public function buatAkunPenggunaByAdmin()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user()->nama;
        $halaman = 'contentAddAllUserByAdmin';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user'));
    }
    // simpan akun admin
    public function SimpanAkunAdmin(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:50',
            'password' => 'required|string|max:8',
            'role' => 'required|string',
            'status' => 'string',
            'no_hp' => 'integer'
        ]);
        // dd($request->all());
        if (User::where('username', $request->username)->exists()) {
            return redirect()->back()->with('gagal', 'username dan password sudah digunakan, silakan gunakan username lain!');
        }

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
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Akun admin berhasil dibuat!');
    }
}
