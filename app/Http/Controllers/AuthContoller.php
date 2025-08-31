<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthContoller extends Controller
{
      public function showLoginForm()
    {
        $Data = User::all();
        return view('BlankPage', compact('Data')); // buat view login.blade.php
    }

    public function login(Request $request)
    {
        $Data = User::all();

        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->hak_akses === 1) { // cek jika hak_akses adalah 'admin'
                return redirect()->intended('/dashboard/admin'); // arahkan ke dashboard admin
            }else if (Auth::user()->hak_akses === 2) { // cek jika hak_akses adalah 'mahasiswa'
                return redirect()->intended('/dashboard/mahasiswa'); // arahkan ke dashboard mahasiswa
            }
            // return redirect()->intended('/dashboard/mahasiswa'); // arahkan ke dashboard
        }

        return back()->withErrors([
            'username' => 'username atau password salah!.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
