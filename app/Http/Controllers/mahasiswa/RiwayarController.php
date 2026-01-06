<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayarController extends Controller
{
    // method untuk menampilkan data riwayat by satatus
    public function SimpanSessionriwayatByStatus(Request $request)
    {
        $status = $request->input('status');

        session()->put('status-riwayat', $status);

        return back();
    }
}