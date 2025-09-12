<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// class return view dashboard
class DashboardController extends Controller
{
    // method untuk agar admin hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function admin()
    {
        if (Auth::user()->hak_akses !== 1) {
            abort(403, 'Unauthorized');
        }
        return view('Page_admin.dashboard-admin');
    }
    
    // method untuk agar mahasiswa hanya bisa mengakses halaman sesuai dengan hak aksesnya
    public function mahasiswa()
    {
        if (Auth::user()->hak_akses !== 2) {
            abort(403, 'Unauthorized');
        }
        return view('Page_mhs.dashboardMhs');
    }
}






