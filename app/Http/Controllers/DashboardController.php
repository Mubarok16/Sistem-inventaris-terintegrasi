<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// class return view dashboard
class DashboardController extends Controller
{
    // return view dshboard mhs
    // public function dashboardMhs()
    // {
    //     return view('Page_mhs.dashboardMhs');
    // }
    // // return view dashboard admin
    // public function dashboardAdmin()
    // {
    //     return view('Page_admin.dashboard-admin');
    // }
    // hak akses controller
    public function admin()
    {
        if (Auth::user()->hak_akses !== 1) {
            abort(403, 'Unauthorized');
        }
        return view('Page_admin.dashboard-admin');
    }

    public function mahasiswa()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        return view('Page_mhs.dashboardMhs');
    }
}






