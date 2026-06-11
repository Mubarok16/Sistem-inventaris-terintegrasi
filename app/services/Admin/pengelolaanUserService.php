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
            $AkunUsers = DB::table('users')
                ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
                ->leftJoin('detail_staff', 'detail_staff.id_user', '=', 'users.id_user')
                ->leftJoin('peminjam', 'peminjam.id_user', '=', 'users.id_user')
                ->select(
                    'users.*',

                    'detail_dosen.nidn',
                    'detail_dosen.nama as nama_dosen',

                    'detail_staff.nip',
                    'detail_staff.nama as nama_staff',

                    'peminjam.no_identitas',
                    'peminjam.nama_peminjam',
                    'peminjam.prodi',
                    'peminjam.img_identitas',
                )
                ->where('users.status', $status)
                ->orderBy('users.created_at', 'desc');
        } elseif ($role === 'mahasiswa') {
            $AkunUsers = DB::table('users')
                ->leftJoin('peminjam', 'peminjam.id_user', '=', 'users.id_user')
                ->select(
                    'users.*',

                    'peminjam.no_identitas',
                    'peminjam.nama_peminjam',
                    'peminjam.prodi',
                    'peminjam.img_identitas'
                )
                ->where('users.status', '=', $status)
                ->where('users.hak_akses', '=', 'mahasiswa')
                ->orderBy('users.created_at', 'desc');
        } elseif ($role === 'pimpinan') {
            $AkunUsers = DB::table('users')
                ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
                ->select(
                    'users.*',
                    'detail_dosen.nidn',
                    'detail_dosen.nama as nama_dosen'
                )
                ->where('users.status', '=', $status)
                ->where('users.hak_akses', '=', 'pimpinan')
                ->orderBy('users.created_at', 'desc');
        } elseif ($role === 'kaprodi') {
            $AkunUsers = DB::table('users')
                ->leftJoin('detail_dosen', 'detail_dosen.id_user', '=', 'users.id_user')
                ->select(
                    'users.*',
                    'detail_dosen.nidn',
                    'detail_dosen.nama as nama_dosen'
                )
                ->where('users.status', '=', $status)
                ->where('users.hak_akses', '=', 'kaprodi')
                ->orderBy('users.created_at', 'desc');
        } elseif ($role === 'staff') {
            $AkunUsers = DB::table('users')
                ->leftJoin('detail_staff', 'detail_staff.id_user', '=', 'users.id_user')
                ->select(
                    'users.*',
                    'detail_staff.nip',
                    'detail_staff.nama as nama_staff'
                )
                ->where('users.status', '=', $status)
                ->where('users.hak_akses', '=', 'admin')
                ->orderBy('users.created_at', 'desc');
        }

        return [
            'AkunUsers' => $AkunUsers,
        ];
    }
}
