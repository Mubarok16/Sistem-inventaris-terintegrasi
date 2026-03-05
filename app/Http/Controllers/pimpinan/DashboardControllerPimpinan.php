<?php

namespace App\Http\Controllers\pimpinan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardControllerPimpinan extends Controller
{

    public function tglDashboardPimpinan(Request $request)
    {
        $tglInput = $request->input('tanggal');
        session()->put('bulan-input', $tglInput); // Simpan bulan ke dalam session
        // dd($request->all());
        return redirect()->back();
    }

}