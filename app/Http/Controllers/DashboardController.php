<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// class return view dashboard
class DashboardController extends Controller
{
    // return view dshboard mhs
    public function dashboardMhs()
    {
        return view('Page_mhs.dashboardMhs');
    }
    // return view dashboard admin
    public function dashboardAdmin()
    {
        return view('Page_admin.dashboard-admin');
    }
}






