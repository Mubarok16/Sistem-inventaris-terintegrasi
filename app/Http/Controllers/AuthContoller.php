<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// class AuthContoller untuk mengelola login users 
class AuthContoller extends Controller
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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->hak_akses === 1) { // cek jika hak_akses adalah 'admin'
                return redirect()->intended('/dashboard/admin'); // arahkan ke dashboard admin
            } else if (Auth::user()->hak_akses === 2) { // cek jika hak_akses adalah 'mahasiswa'
                return redirect()->intended('/dashboard/mahasiswa'); // arahkan ke dashboard mahasiswa
            }

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
