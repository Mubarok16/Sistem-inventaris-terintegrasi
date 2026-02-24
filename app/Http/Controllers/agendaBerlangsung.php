<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class agendaBerlangsung extends Controller
{
    public function DetailAgendaBerlangsung($id)
    {

        $agendafakultas = DB::table('agenda_fakultas')
            ->where('agenda_fakultas.kode_agenda', $id)
            ->count();

        if ($agendafakultas === 1) {
            // dd('uhuy');
            return redirect()->route('admin-detail-agenda', ['id' => urlencode($id)]);
        } else {
            return redirect()->route('admin.detailPeminjaman', ['id' => $id]);
            // dd('gagal');
        }
        
    }
}
