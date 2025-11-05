<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjam;
use Illuminate\Support\Facades\Hash;

class CreateAkun extends Controller
{
    public function showCreateAkunForm()
    {
        return view('BuatAkun'); // retun menampilkan view login.blade.php
        // }
    }

    public function SimpanAkun(Request $request)
    {
        $request->validate([
            'no_identitas' => 'required|integer|unique:peminjam,no_identitas',
            'nama_peminjam' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:peminjam,username',
            'password' => 'required|string|min:6',
            // 'fakultas' => 'required|string',
            'prodi' => 'required|string',
            'img_identitas' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan file gambar jika diupload
        $imgPath = null;
        if ($request->hasFile('img_identitas')) {
            $imgPath = $request->file('img_identitas')->store('uploads/identitas', 'public');
        }

        // Simpan data ke database
        Peminjam::create([
            'no_identitas' => $request->no_identitas,
            'nama_peminjam' => $request->nama_peminjam,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'fakultas' => "coba",
            'prodi' => $request->prodi,
            'img_identitas' => $imgPath,
        ]);

        return redirect()->intended('/create-akun-peminjam')->with('success', 'Akun berhasil dibuat!');
    }
}
