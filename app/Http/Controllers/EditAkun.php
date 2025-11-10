<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;



class EditAkun extends Controller
{
    public function EditAkunUser(Request $request, $id)
    {
        try {
            $request->validate([
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:50',
                'password' => 'required|string|max:12',
                'hak_akses' => 'required|string',
            ]);

            $user = User::where('id_user', $id)->firstOrFail();

            $user->update([
                'nama' => $request->nama,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'hak_akses' => $request->hak_akses,
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Akun ' . $user->nama . ' berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('gagal', 'Akun gagal diperbarui!');
        }
    }
}
