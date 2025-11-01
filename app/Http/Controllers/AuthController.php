<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// class AuthContoller untuk mengelola login users 
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('BlankPage'); // retun menampilkan view login.blade.php
        // }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->hak_akses === "admin") { // cek jika hak_akses adalah 'admin/tendik'
                return redirect()->intended('/dashboard/admin'); // arahkan ke dashboard admin
            } elseif (Auth::user()->hak_akses === "pimpinan") { // cek jika hak_akses adalah 'pimpinan'
                return redirect()->intended('/dashboard/pimpinan'); // arahkan ke dashboard dosen
            } elseif (Auth::user()->hak_akses === "kaprodi") { // cek jika hak_akses adalah 'kaprodi'
                return redirect()->intended('/dashboard/kaprodi'); // arahkan ke dashboard kaprodi
            } else {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akses tidak dikenali.',
                ]);
            }
        }

        if (Auth::guard('peminjam')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/mahasiswa'); // arahkan ke dashboard admin
        }

        return back()->withErrors([
            'username' => 'username atau password salah!.',
        ]);
    }
    // method untuk logout users
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
