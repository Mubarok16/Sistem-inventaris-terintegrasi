<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PengelolaanUserController extends Controller
{
    public function filterRole(Request $request)
    {
        // dd($request->all());
        Session::put('filter-role', $request->role);
        return redirect()->route('pengelolaan-user');
    }

    public function filterStatus(Request $request)
    {
        // dd($request->all());
        Session::put('filter-status', $request->status);
        return redirect()->route('pengelolaan-user');
    }
}
