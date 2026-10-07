<?php

namespace App\Http\Controllers;

use App\Imports\MahasiswaImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class PengelolaanUserController extends Controller
{
    public function filterRole(Request $request)
    {
        Session::put('filter-role', $request->role);
        return redirect()->route('pengelolaan-user');
    }

    public function filterStatus(Request $request)
    {
        Session::put('filter-status', $request->status);
        return redirect()->route('pengelolaan-user');
    }

    /**
     * Download template import akun mahasiswa.
     */
    public function downloadTemplateImportMahasiswa()
    {
        $this->pastikanAdmin();

        $filePath = public_path('templates/template_import_akun_mahasiswa.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('gagal', 'Template import akun mahasiswa tidak ditemukan.');
        }

        return response()->download($filePath, 'template_import_akun_mahasiswa.xlsx');
    }

    /**
     * Import akun mahasiswa dari Excel/CSV.
     *
     * Kolom template:
     * no_identitas, nama_peminjam, username, password, prodi, tahun_masuk, status
     */
    public function importMahasiswa(Request $request)
    {
        $this->pastikanAdmin();

        $validator = Validator::make($request->all(), [
            'fileMahasiswa' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ], [
            'fileMahasiswa.required' => 'Pilih file Excel/CSV mahasiswa terlebih dahulu.',
            'fileMahasiswa.mimes' => 'Format file harus .xlsx, .xls, atau .csv.',
            'fileMahasiswa.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('gagal', $validator->errors()->first());
        }

        try {
            $import = new MahasiswaImport();
            Excel::import($import, $request->file('fileMahasiswa'));

            if (empty($import->rows)) {
                return redirect()->back()->with('gagal', 'File import tidak berisi data mahasiswa.');
            }

            // Nama program studi di template harus sama dengan data Program Studi pada sistem.
            $prodiDb = DB::table('prodi')
                ->pluck('nama_prodi')
                ->mapWithKeys(function ($nama) {
                    return [Str::lower(trim((string) $nama)) => (string) $nama];
                })
                ->toArray();

            $dataSiapSimpan = [];
            $npmDalamFile = [];
            $usernameDalamFile = [];

            foreach ($import->rows as $index => $row) {
                $nomorBaris = $index + 2; // heading berada di baris pertama

                $noIdentitas = trim((string) ($row['no_identitas'] ?? ''));
                $nama = trim((string) ($row['nama_peminjam'] ?? ''));
                $username = trim((string) ($row['username'] ?? ''));
                $password = trim((string) ($row['password'] ?? ''));
                $prodiInput = trim((string) ($row['prodi'] ?? ''));
                $tahunMasuk = trim((string) ($row['tahun_masuk'] ?? ''));
                $statusInput = Str::lower(trim((string) ($row['status'] ?? 'active')));

                if ($noIdentitas === '' || $nama === '' || $username === '' || $password === '' || $prodiInput === '' || $tahunMasuk === '') {
                    return redirect()->back()->with(
                        'gagal',
                        "Baris {$nomorBaris}: no_identitas, nama_peminjam, username, password, prodi, dan tahun_masuk wajib diisi."
                    );
                }

                if (!ctype_digit($noIdentitas) || strlen($noIdentitas) > 12) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: no_identitas/NPM harus berupa angka maksimal 12 digit.");
                }

                if (mb_strlen($nama) > 100) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: nama mahasiswa maksimal 100 karakter.");
                }

                // Kolom username pada database dibatasi 12 karakter.
                if (mb_strlen($username) > 12) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: username maksimal 12 karakter.");
                }

                if (mb_strlen($password) > 12) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: password maksimal 12 karakter.");
                }

                if (!ctype_digit($tahunMasuk) || (int) $tahunMasuk < 1900 || (int) $tahunMasuk > 2100) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: tahun_masuk harus berupa tahun 4 digit yang valid.");
                }

                if (in_array($statusInput, ['active', 'aktif'], true)) {
                    $status = 'active';
                } elseif (in_array($statusInput, ['unactive', 'nonaktif', 'non-active', 'inactive'], true)) {
                    $status = 'unactive';
                } else {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: status hanya boleh active atau unactive.");
                }

                $prodiKey = Str::lower($prodiInput);
                if (!empty($prodiDb) && !array_key_exists($prodiKey, $prodiDb)) {
                    return redirect()->back()->with(
                        'gagal',
                        "Baris {$nomorBaris}: program studi '{$prodiInput}' belum terdaftar pada menu Program Studi."
                    );
                }

                $prodi = $prodiDb[$prodiKey] ?? $prodiInput;
                $usernameKey = Str::lower($username);

                if (isset($npmDalamFile[$noIdentitas])) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: NPM/no_identitas {$noIdentitas} duplikat di dalam file.");
                }

                if (isset($usernameDalamFile[$usernameKey])) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: username {$username} duplikat di dalam file.");
                }

                if (DB::table('peminjam')->where('no_identitas', $noIdentitas)->exists()) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: NPM/no_identitas {$noIdentitas} sudah terdaftar.");
                }

                if (DB::table('users')->whereRaw('LOWER(username) = ?', [$usernameKey])->exists()) {
                    return redirect()->back()->with('gagal', "Baris {$nomorBaris}: username {$username} sudah digunakan.");
                }

                $npmDalamFile[$noIdentitas] = true;
                $usernameDalamFile[$usernameKey] = true;

                $dataSiapSimpan[] = [
                    'no_identitas' => $noIdentitas,
                    'nama_peminjam' => $nama,
                    'username' => $username,
                    'password' => $password,
                    'prodi' => $prodi,
                    'fakultas' => $this->tentukanFakultas($prodi),
                    'tahun_masuk' => (int) $tahunMasuk,
                    'status' => $status,
                ];
            }

            DB::transaction(function () use ($dataSiapSimpan) {
                foreach ($dataSiapSimpan as $data) {
                    do {
                        $idUser = Str::random(12);
                    } while (DB::table('users')->where('id_user', $idUser)->exists());

                    DB::table('users')->insert([
                        'id_user' => $idUser,
                        'username' => $data['username'],
                        'password' => Hash::make($data['password']),
                        'hak_akses' => 'mahasiswa',
                        'status' => $data['status'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // Foto identitas tidak diimpor lewat Excel. String kosong digunakan agar
                    // format tabel lama yang belum nullable tetap kompatibel.
                    DB::table('peminjam')->insert([
                        'no_identitas' => $data['no_identitas'],
                        'id_user' => $idUser,
                        'nama_peminjam' => $data['nama_peminjam'],
                        'fakultas' => $data['fakultas'],
                        'prodi' => $data['prodi'],
                        'img_identitas' => '',
                        'tahun_masuk' => $data['tahun_masuk'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

            return redirect()->route('pengelolaan-user')->with(
                'success',
                count($dataSiapSimpan) . ' akun mahasiswa berhasil diimpor.'
            );
        } catch (\Throwable $e) {
            return redirect()->back()->with(
                'gagal',
                'Import akun mahasiswa gagal. Pastikan format file mengikuti template. Detail: ' . $e->getMessage()
            );
        }
    }

    private function pastikanAdmin(): void
    {
        if (!Auth::check() || Auth::user()->hak_akses !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    private function tentukanFakultas(string $prodi): string
    {
        $prodi = Str::lower(trim($prodi));

        $mapping = [
            'teknik' => [
                'teknik sipil', 'teknik komputer', 'teknik informatika',
                'teknik lingkungan', 'teknik mesin', 'teknik elektro', 'arsitektur',
            ],
            'hukum' => ['ilmu hukum'],
            'ekonomi' => ['manajemen'],
            'keguruan dan ilmu pendidikan' => [
                'pendidikan bahasa inggris', 'pendidikan bahasa indonesia',
                'pendidikan matematika', 'pendidikan biologi',
            ],
            'ilmu sosial dan politik' => ['ilmu politik'],
            'agama islam' => ['pendidikan agama islam', 'ekonomi syariah', 'bimbingan konseling islam'],
            'pertanian' => ['agribisnis', 'agroteknologi'],
            'kesehatan masyarakat' => ['kesehatan masyarakat'],
        ];

        foreach ($mapping as $fakultas => $daftarProdi) {
            if (in_array($prodi, $daftarProdi, true)) {
                return $fakultas;
            }
        }

        // Sistem ini digunakan di lingkungan Fakultas Teknik. Untuk program studi
        // teknik baru yang belum ada pada mapping, tetap kelompokkan ke Teknik.
        if (Str::contains($prodi, 'teknik')) {
            return 'teknik';
        }

        return 'lainnya';
    }
}
