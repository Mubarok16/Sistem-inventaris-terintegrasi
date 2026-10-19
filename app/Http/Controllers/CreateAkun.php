<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Contracts\Service\Attribute\Required;

class CreateAkun extends Controller
{
    /**
     * Resolve student program and intake year from the official 12-digit NPM format.
     * The first five digits identify the program; digits 8-9 identify the intake year.
     */
    private function getStudentInfoFromNpm(?string $npm): ?array
    {
        if (!$npm || !preg_match('/^\\d{12}$/', $npm)) {
            return null;
        }

        $programs = [
            '22201' => ['prodi' => 'teknik sipil', 'label' => 'Teknik Sipil', 'fakultas' => 'teknik'],
            '13201' => ['prodi' => 'kesehatan masyarakat', 'label' => 'Kesehatan Masyarakat', 'fakultas' => 'kesehatan masyarakat'],
            '54201' => ['prodi' => 'agribisnis', 'label' => 'Agribisnis', 'fakultas' => 'pertanian'],
            '54211' => ['prodi' => 'agroteknologi', 'label' => 'Agroteknologi', 'fakultas' => 'pertanian'],
            '56202' => ['prodi' => 'teknik komputer', 'label' => 'Teknik Komputer', 'fakultas' => 'teknik'],
            '61201' => ['prodi' => 'manajemen', 'label' => 'Manajemen', 'fakultas' => 'ekonomi'],
            '61206' => ['prodi' => 'perbankan syariah', 'label' => 'Perbankan Syariah', 'fakultas' => 'agama islam'],
            '65201' => ['prodi' => 'ilmu pemerintahan', 'label' => 'Ilmu Pemerintahan', 'fakultas' => 'ilmu sosial dan politik'],
            '70232' => ['prodi' => 'bimbingan konseling islam', 'label' => 'Bimbingan dan Konseling Islam (BKPI)', 'fakultas' => 'agama islam'],
            '74201' => ['prodi' => 'ilmu hukum', 'label' => 'Ilmu Hukum', 'fakultas' => 'hukum'],
            '84202' => ['prodi' => 'pendidikan matematika', 'label' => 'Pendidikan Matematika', 'fakultas' => 'keguruan dan ilmu pendidikan'],
            '84205' => ['prodi' => 'pendidikan biologi', 'label' => 'Pendidikan Biologi', 'fakultas' => 'keguruan dan ilmu pendidikan'],
            '86208' => ['prodi' => 'pendidikan agama islam', 'label' => 'Pendidikan Agama Islam (PAI)', 'fakultas' => 'agama islam'],
            '88201' => ['prodi' => 'pendidikan bahasa indonesia', 'label' => 'Pendidikan Bahasa dan Sastra Indonesia (PBSI)', 'fakultas' => 'keguruan dan ilmu pendidikan'],
            '88203' => ['prodi' => 'pendidikan bahasa inggris', 'label' => 'Pendidikan Bahasa Inggris', 'fakultas' => 'keguruan dan ilmu pendidikan'],
        ];

        $programCode = substr($npm, 0, 5);
        if (!isset($programs[$programCode])) {
            return null;
        }

        $intakeYear = (int) substr($npm, 7, 2);

        return [
            'prodi' => $programs[$programCode]['prodi'],
            'label_prodi' => $programs[$programCode]['label'],
            'fakultas' => $programs[$programCode]['fakultas'],
            'tahun_masuk' => 2000 + $intakeYear,
        ];
    }

    // page signin akun peminjam
    public function showCreateAkunFormPeminjam()
    {
        return view('BuatAkun'); // retun menampilkan view login.blade.php
        // }
    }

    /** Endpoint read-only untuk mengecek NPM saat mahasiswa mengetik pada formulir registrasi. */
    public function cekNpmTerdaftar(Request $request)
    {
        $npm = (string) $request->query('npm', '');
        if (!preg_match('/^\\d{12}$/', $npm)) {
            return response()->json(['valid' => false, 'terdaftar' => false, 'message' => 'Masukkan NPM yang terdiri dari 12 angka.']);
        }

        $terdaftar = DB::table('peminjam')->where('no_identitas', $npm)->exists();

        return response()->json([
            'valid' => true,
            'terdaftar' => $terdaftar,
            'message' => $terdaftar ? 'NPM sudah terdaftar. Silakan masuk atau periksa kembali NPM Anda.' : 'NPM belum terdaftar dan dapat dilanjutkan.',
        ]);
    }

    // simpan akun peminjam ke db dari signin
    public function SimpanAkunPeminjam(Request $request)
    {
        $studentInfo = $this->getStudentInfoFromNpm((string) $request->input('no_identitas'));
        if (!$studentInfo) {
            return redirect()->back()->withInput()->with('gagal', 'NPM tidak valid atau kode program studi tidak dikenali. Pastikan NPM 12 digit dan sesuai data kampus.');
        }

        if (DB::table('peminjam')->where('no_identitas', $request->no_identitas)->exists()) {
            return redirect()->back()->withInput()->with('gagal', 'NPM tersebut sudah terdaftar. Silakan masuk menggunakan akun yang sudah ada.');
        }

        try {
            $request->validate([
                'no_identitas' => 'required|string|regex:/^\\d{12}$/',
                'nama_peminjam' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'required|string|max:12',
                'img_identitas' => 'required|image|mimes:jpg,jpeg,png',
            ]);

            // cek username sudah ada atau belum
            if (DB::table('users')->where('username', $request->username)->exists()) {
                return redirect()->back()->with('gagal', 'pastikan username dan password anda unik!, silakan gunakan username lain!');
            }

            // Simpan file gambar jika diupload
            $imgPath = null;
            if ($request->hasFile('img_identitas')) {
                $imgPath = $request->file('img_identitas')->store('uploads/identitas', 'public');
            }

            $fakultas = $studentInfo['fakultas'];

            // Simpan data ke database
            $id_user_acak = Str::random(12);
            DB::table('users')->insert([
                'id_user' => $id_user_acak,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'hak_akses' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 'unactive',
            ]);

            DB::table('peminjam')->insert([
                'no_identitas' => $request->no_identitas,
                'id_user' => $id_user_acak,
                'nama_peminjam' => $request->nama_peminjam,
                'fakultas' => $fakultas,
                'prodi' => $studentInfo['prodi'],
                'img_identitas' => $imgPath,
                'tahun_masuk' => $studentInfo['tahun_masuk'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->intended('/create-akun-peminjam')->with('success', 'Akun berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal dibuat pastikan anda belum memiliki akun dan npm yang anda input sesuai!!');
            // dd('Error saat update:', $e->getMessage());
        }
    }

    // simpan akun peminjam (mhs) dari admin
    public function showCreateAkunPeminjamFormAdmin(Request $request)
    {
        $studentInfo = $this->getStudentInfoFromNpm((string) $request->input('no_identitas'));
        if (!$studentInfo) {
            return redirect()->back()->withInput()->with('gagal', 'NPM tidak valid atau kode program studi tidak dikenali. Pastikan NPM 12 digit dan sesuai data kampus.');
        }

        if (DB::table('peminjam')->where('no_identitas', $request->no_identitas)->exists()) {
            return redirect()->back()->withInput()->with('gagal', 'NPM tersebut sudah terdaftar.');
        }

        // Tampilan form admin tetap, tetapi prodi dan tahun masuk ditentukan dari NPM.
        try {

            $request->validate([
                'no_identitas' => 'required|string|regex:/^\\d{12}$/',
                'nama_peminjam' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'required|string|max:12',
                'img_identitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'status' => 'required',
            ]);

            // cek username sudah ada atau belum
            if (DB::table('users')->where('username', $request->username)->exists()) {
                return redirect()->back()->with('gagal', 'pastikan username dan password anda unik!, silakan gunakan username lain!');
            }

            // Simpan file gambar jika diupload
            $imgPath = null;
            if ($request->hasFile('img_identitas')) {
                $imgPath = $request->file('img_identitas')->store('uploads/identitas', 'public');
            }

            $fakultas = $studentInfo['fakultas'];

            // Simpan data ke database
            $id_user_acak = Str::random(12);
            DB::table('users')->insert([
                'id_user' => $id_user_acak,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'hak_akses' => 'mahasiswa',
                'created_at' => now(),
                'updated_at' => now(),
                'status' => $request->status,
            ]);

            DB::table('peminjam')->insert([
                'no_identitas' => $request->no_identitas,
                'id_user' => $id_user_acak,
                'nama_peminjam' => $request->nama_peminjam,
                'fakultas' => $fakultas,
                'prodi' => $studentInfo['prodi'],
                'img_identitas' => $imgPath,
                'tahun_masuk' => $studentInfo['tahun_masuk'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Akun ' . $request->nama . ' berhasil dibuat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal dibuat!' . $e);
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

        $prodi = DB::table('prodi')->select('nama_prodi')->get();

        // $user = Auth::user()->nama;
        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentAddAllUserByAdmin';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'prodi'));
    }
    // simpan akun admin
    public function SimpanAkunAdmin(Request $request)
    {
        try {
            $request->validate([
                'nip' => 'required|max:12',
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'required|string|max:12',
                'role' => 'required|string',
                'status' => 'string',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('gagal', 'Gagal membuat akun admin! pastikan data yang anda input sudah benar');
        }
        // $request->validate([
        //     'nip' => 'required|max:12',
        //     'nama' => 'required|string|max:100',
        //     'username' => 'required|string|max:50',
        //     'password' => 'required|string|max:8',
        //     'role' => 'required|string',
        //     'status' => 'string',
        //     // 'no_hp' => 'integer'
        // ]);
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

        try {
            //code...
            User::create([
                'id_user' => $id_user_acak,
                // 'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'hak_akses' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
                'status' => $request->status,
            ]);

            DB::table('detail_staff')->insert([
                'nip' => $request->nip,
                'id_user' => $id_user_acak,
                'nama' => $request->nama,
                'jabatan' => 'Administrasi Akademik',
                // 'username' => $request->username,
                // 'password' => Hash::make($request->password),
                // 'hak_akses' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
                // 'status' => $request->status,
            ]);
            return redirect()->back()->with('success', 'Akun admin berhasil dibuat!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('gagal', 'Gagal membuat akun admin!');
        }
    }

    //========================== simpan akun kaprodi
    // simpan akun kaprodi
    public function SimpanAkunKaprodi(Request $request)
    {
        // dd($request->all());

        try {
            $request->validate([
                'nip' => 'required|max:12',
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'required|string|max:12',
                'jabatan' => 'required',
                'role' => 'required|string',
                'status' => 'string',
            ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('gagal', 'Gagal membuat akun kaprodi! pastikan data yang anda input sudah benar');
        }

        // $request->validate([
        //     'nip' => 'required|max:12',
        //     'nama' => 'required|string|max:100',
        //     'username' => 'required|string|max:50',
        //     'password' => 'required|string|max:8',
        //     'jabatan' => 'required',
        //     'role' => 'required|string',
        //     'status' => 'string',
        //     // 'no_hp' => 'integer'
        // ]);
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

        try {
            //code...
            // dd($id_user_acak);
            User::create([
                'id_user' => $id_user_acak,
                // 'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'hak_akses' => 'kaprodi',
                'created_at' => now(),
                'updated_at' => now(),
                'status' => $request->status,
            ]);

            DB::table('detail_dosen')->insert([
                'nidn' => $request->nip,
                'id_user' => $id_user_acak,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                // 'username' => $request->username,
                // 'password' => Hash::make($request->password),
                // 'hak_akses' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
                // 'status' => $request->status,
            ]);
            return redirect()->back()->with('success', 'Akun kaprodi berhasil dibuat!');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('gagal', 'Gagal membuat akun kaprodi!');
        }
    }

    //============================= tambah prodi
    // page
    public function Prodi()
    {
        if (Auth::user()->hak_akses  !== "admin") {
            abort(403, 'Unauthorized');
        }

        $prodi = DB::table('prodi')->get();

        // $user = Auth::user()->nama;
        $user = DB::table('detail_staff')->where('id_user', Auth::user()->id_user)->value('nama');
        $halaman = 'contentProdi';
        return view('Page_admin.dashboard-admin', compact('halaman', 'user', 'prodi'));
    }

    // tambah prodi
    public function tambahProdi(Request $request)
    {
        // dd($request->all());
        try {
            DB::table('prodi')->insert([
                'id_prodi' => Str::random(12),
                'nama_prodi' => $request->nama_prodi,
            ]);

            return redirect()->back()->with('success', 'berhasi menambah data program studi');
        } catch (\Throwable $th) {
            return redirect()->back()->with('gagal', 'gagal menambah data program studi');
        }
    }

    public function hpsProdi($id)
    {
        // dd($id);
        try {
            DB::table('prodi')
                ->where('id_prodi', $id)
                ->delete();

            return redirect()->back()->with('success', 'berhasi menghapus data program studi');
        } catch (\Throwable $th) {
            return redirect()->back()->with('gagal', 'gagal menghapus data program studi');
        }
    }
}
