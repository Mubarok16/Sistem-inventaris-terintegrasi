<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class peminjamanbarangController extends Controller
{
    // cek ketersediaan barang
    public function cekKetersediaanBarang(Request $request)
    {
        dd($request->all());
        // return redirect()->route('mhs-peminjaman-barang', ['#ketersediaan']);
    }
}
