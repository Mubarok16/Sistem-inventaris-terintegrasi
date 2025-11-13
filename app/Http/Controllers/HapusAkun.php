<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use App\Models\User;

class HapusAkun extends Controller
{
    public function HapusAkunAdmin(Request $request)
    {
        try {
            $request->validate([
                'id_user' => 'required|string',
            ]);

            // dd($request->all());

            $user = User::where('id_user', $request->id_user)->first();
            $user->delete();

            return redirect()->back()->with('success', 'Akun berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }
    }

    public function HapusAkunPeminjam(Request $request)
    {
        try {
            $request->validate([
                'no_identitas' => 'required|string',
            ]);

            // dd($request->all());

            $user = Peminjam::where('no_identitas', $request->no_identitas)->first();
            $user->delete();

            return redirect()->back()->with('success', 'Akun berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', $e->getMessage());
        }
    }
}
