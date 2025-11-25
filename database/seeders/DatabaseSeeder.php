<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        User::create([
            'id_user' => Str::random(12),
            'nama' => 'staff',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'hak_akses' => 'admin',
            'no_hp' => '08123423',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        User::create([
            'id_user' => Str::random(12),
            'nama' => 'Ka Prodi teknik komputer',
            'username' => 'kaproditkm',
            'password' => bcrypt('kaproditkm'),
            'hak_akses' => 'kaprodi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'id_user' => Str::random(12),
            'nama' => 'Ka Prodi teknik sipil',
            'username' => 'kaprodispl',
            'password' => bcrypt('kaprodispl'),
            'hak_akses' => 'kaprodi',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        User::create([
            'id_user' => Str::random(12),
            'nama' => 'wakil dekan',
            'username' => 'wadek',
            'password' => bcrypt('wadek'),
            'hak_akses' => 'pimpinan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


    }
}
