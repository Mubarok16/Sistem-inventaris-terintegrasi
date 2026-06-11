<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // ==========================================
        // 1. DATA DOSEN
        // ==========================================
        DB::table('users')->insert([
            'id_user'   => 'USR-DSN001',
            'username'  => 'kaproditkm',
            'password'  => Hash::make('kaproditkm'), // Enkripsi password
            'hak_akses' => 'kaprodi',
            'status'    => 'aktif',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        DB::table('detail_dosen')->insert([
            'nidn'       => '0412038901',
            'id_user'    => 'USR-DSN001',
            'nama'       => 'kaprodi Teknik komputer',
            'no_hp'      => null,
            'jabatan'    => 'kaprodi Teknik komputer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id_user'   => 'USR-DSN002',
            'username'  => 'kaprodispl',
            'password'  => Hash::make('kaprodispl'), // Enkripsi password
            'hak_akses' => 'kaprodi',
            'status'    => 'aktif',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        DB::table('detail_dosen')->insert([
            'nidn'       => '0412038902',
            'id_user'    => 'USR-DSN002',
            'nama'       => 'kaprodi teknik sipil',
            'no_hp'      => null,
            'jabatan'    => 'kaprodi teknik sipil',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id_user'   => 'USR-DSN003',
            'username'  => 'kaproditl',
            'password'  => Hash::make('kaproditl'), // Enkripsi password
            'hak_akses' => 'kaprodi',
            'status'    => 'aktif',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        DB::table('detail_dosen')->insert([
            'nidn'       => '0412038903',
            'id_user'    => 'USR-DSN003',
            'nama'       => 'kaprodi teknik lingkungan',
            'no_hp'      => null,
            'jabatan'    => 'kaprodi teknik lingkungan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id_user'   => 'USR-DSN004',
            'username'  => 'wadek',
            'password'  => Hash::make('wadek'), // Enkripsi password
            'hak_akses' => 'kaprodi',
            'status'    => 'aktif',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        DB::table('detail_dosen')->insert([
            'nidn'       => '0412038904',
            'id_user'    => 'USR-DSN004',
            'nama'       => 'Wadek',
            'no_hp'      => null,
            'jabatan'    => 'Wakil Dekan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ==========================================
        // 2. DATA STAFF / ADMIN
        // ==========================================
        DB::table('users')->insert([
            'id_user'   => 'USR-STF001',
            'username'  => 'admin',
            'password'  => Hash::make('admin123'),
            'hak_akses' => 'admin',
            'status'    => 'aktif',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        DB::table('detail_staff')->insert([
            'nip'        => '19950812001',
            'id_user'    => 'USR-STF001',
            'nama'       => 'Admin',
            'no_hp'      =>  null,
            'jabatan'    => 'Administrasi Akademik',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ==========================================
        // 3. DATA PEMINJAM (MAHASISWA/UMUM)
        // ==========================================
        DB::table('users')->insert([
            'id_user'   => 'USR-PMJ001',
            'username'  => 'farhan',
            'password'  => Hash::make('farhan'),
            'hak_akses' => 'mahasiswa',
            'status'    => 'aktif',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);

        DB::table('peminjam')->insert([
            'no_identitas'  => '22010304001',
            'id_user'       => 'USR-PMJ001',
            'nama_peminjam' => 'Farhan',
            'fakultas'      => 'Teknik',
            'prodi'         => 'Teknik Informatika',
            'img_identitas' => 'ktm_farhan.jpg', // Nama file contoh gambar
            'tahun_masuk'   => 2021,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

    }
}
