<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\DB;

class PengelolaanUserService
{
    // public function dataAllUsersByStatus($status) {
    //     if ($status === 'all') {
    //         $AkunPeminjams = DB::table('peminjam')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         $AkunUsers = DB::table('users')
    //             ->orderBy('created_at', 'desc')
    //             ->get();
    //     } elseif ($status === 'active') {

    //         $AkunPeminjams = DB::table('peminjam')
    //             ->where('status', '=', 'active')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         $AkunUsers = DB::table('users')
    //             ->where('status', '=', 'active')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //     } else{

    //         $AkunPeminjams = DB::table('peminjam')
    //             ->where('status', '=', 'unactive')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //         $AkunUsers = DB::table('users')
    //             ->where('status', '=', 'unactive')
    //             ->orderBy('created_at', 'desc')
    //             ->get();

    //     } 

    //     return [
    //         'AkunPeminjams' => $AkunPeminjams,
    //         'AkunUsers' => $AkunUsers,
    //     ];
    // }

    public function dataAllUsersByFilter($role, $status)
    {

        if ($role === 'all') {
            $AkunPeminjams = DB::table('peminjam')
                ->where('status', '=', $status)
                ->orderBy('created_at', 'desc')
                ->get();

            $AkunUsers = DB::table('users')
                ->where('status', '=', $status)
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($role === 'mahasiswa') {

            $AkunPeminjams = DB::table('peminjam')
                ->where('status', '=', $status)
                ->orderBy('created_at', 'desc')
                ->get();

            $AkunUsers = DB::table('users')
                ->where('status', '=', $status)
                ->where('hak_akses', '=', 'mahasiswa')
                ->orderBy('created_at', 'desc')
                ->get();

        } elseif ($role === 'pimpinan') {

            $AkunPeminjams = DB::table('peminjam')
                ->where('status', '=', $status)
                ->where('no_identitas', '=', 'asd')
                ->orderBy('created_at', 'desc')
                ->get();

            $AkunUsers = DB::table('users')
                ->where('status', '=', $status)
                ->where('hak_akses', '=', 'pimpinan')
                ->orderBy('created_at', 'desc')
                ->get();

        } elseif ($role === 'kaprodi') {
            $AkunPeminjams = DB::table('peminjam')
                ->where('status', '=', $status)
                ->where('no_identitas', '=', '123')
                ->orderBy('created_at', 'desc')
                ->get();

            $AkunUsers = DB::table('users')
                ->where('status', '=', $status)
                ->where('hak_akses', '=', 'kaprodi')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($role === 'staff') {
            $AkunPeminjams = DB::table('peminjam')
                ->where('status', '=', $status)
                ->where('no_identitas', '=', '123')
                ->orderBy('created_at', 'desc')
                ->get();

            $AkunUsers = DB::table('users')
                ->where('status', '=', $status)
                ->where('hak_akses', '=', 'admin')
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return [
            'AkunPeminjams' => $AkunPeminjams,
            'AkunUsers' => $AkunUsers,
        ];
    }
}
