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
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // User::create([
        //     'id_user' => Str::random(12),
        //     'nama' => 'staff',
        //     'username' => 'admin',
        //     'password' => bcrypt('admin'),
        //     'hak_akses' => 'admin',
        //     'no_hp' => '08123423',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        
        // User::create([
        //     'id_user' => Str::random(12),
        //     'nama' => 'Ka Prodi teknik komputer',
        //     'username' => 'kaproditkm',
        //     'password' => bcrypt('kaproditkm'),
        //     'hak_akses' => 'kaprodi',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // User::create([
        //     'id_user' => Str::random(12),
        //     'nama' => 'Ka Prodi teknik sipil',
        //     'username' => 'kaprodispl',
        //     'password' => bcrypt('kaprodispl'),
        //     'hak_akses' => 'kaprodi',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // User::create([
        //     'id_user' => Str::random(12),
        //     'nama' => 'wakil dekan',
        //     'username' => 'wadek',
        //     'password' => bcrypt('wadek'),
        //     'hak_akses' => 'pimpinan',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // 1. DATA UNTUK TABEL USERS (Dipastikan hanya menggunakan role & jabatan yang diminta)
        DB::table('users')->insert([
            [
                'id_user'   => Str::random(12),
                'nama'      => 'Andi Wijaya, M.T.',
                'username'  => 'kaprodi_tk',
                'password'  => Hash::make('password123'),
                'hak_akses' => 'kaprodi', // Role: kaprodi
                'no_hp'     => null,
                'status'    => 'aktif',
                'jabatan'   => 'Kaprodi Teknik Komputer', // Jabatan 1
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user'   => Str::random(12),
                'nama'      => 'kaprodi teknik sipil',
                'username'  => 'kaprodi_ts',
                'password'  =>  Hash::make('password123'),
                'hak_akses' => 'kaprodi', // Role: kaprodi
                'no_hp'     =>  null,
                'status'    => 'aktif',
                'jabatan'   => 'Kaprodi Teknik Sipil', // Jabatan 2
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user'   => Str::random(12),
                'nama'      => 'kaprodi teknik lingkungan',
                'username'  => 'kaprodi_tl',
                'password'  => Hash::make('password123'),
                'hak_akses' => 'kaprodi', // Role: kaprodi
                'no_hp'     => null,
                'status'    => 'aktif',
                'jabatan'   => 'Kaprodi Teknik Lingkungan', // Jabatan 3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user'   => Str::random(12),
                'nama'      => 'admin sarpras',
                'username'  => 'admin',
                'password'  => Hash::make('admin123'),
                'hak_akses' => 'admin', // Role: admin
                'no_hp'     =>  null,
                'status'    => 'aktif',
                'jabatan'   => 'Staf Administrasi Sarpras',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_user'   => Str::random(12),
                'nama'      => 'wakil dekan',
                'username'  => 'pimpinan_wd',
                'password'  => Hash::make('pimpinan123'),
                'hak_akses' => 'pimpinan', // Role: pimpinan
                'no_hp'     => null,
                'status'    => 'aktif',
                'jabatan'   => 'Wakil Dekan', // Jabatan 4
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


    }
}
