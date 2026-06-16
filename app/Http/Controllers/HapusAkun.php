<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HapusAkun extends Controller
{
    public function HapusAkunAdmin($id)
    {

        $user = User::where('id_user', $id)->first();
        DB::table('detail_staff')->where('id_user', $id)->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil dihapus!');
    }

    public function HapusAkunPeminjam(Request $request)
    {
        try {
            $request->validate([
                'no_identitas' => 'required|string',
            ]);

            // dd($request->all());

            $peminjam = Peminjam::where('no_identitas', $request->no_identitas)->first();
            $user = User::where('id_user', $peminjam->id_user)->first();
            $peminjam->delete();
            $user->delete();

            return redirect()->back()->with('success', 'Akun berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'akun ini masih terkait peminjaman');
        }
    }
}
