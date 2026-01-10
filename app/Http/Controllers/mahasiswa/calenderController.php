<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class calenderController extends Controller
{
    public function calender()
    {
        $agendas = DB::table('usage_rooms')
            ->leftJoin('agenda_fakultas', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
            ->leftJoin('peminjaman', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->select(
                'usage_rooms.kode_agenda',
                'usage_rooms.kode_peminjaman',
                'agenda_fakultas.nama_agenda',
                'peminjaman.ket_peminjaman',
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.tgl_kembali_usage_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'usage_rooms.status_usage_room'
            )
            // ->whereIn('usage_rooms.status_usage_room',['terjadwal', 'digunakan'])
            ->get();

        // $events = $agendas->map(function ($agenda) {

        //     return [
        //         // 'id'    => $agenda->kode_agenda,
        //         'title' => $agenda->nama_agenda === null ? $agenda->ket_peminjaman: $agenda->nama_agenda,
        //         'start' => $agenda->tgl_pinjam_usage_room,
        //         'end'   => $agenda->tgl_kembali_usage_room,
        //         'color' => $this->statusColor($agenda->status_usage_room),
        //     ];
        // });

        // return response()->json($events);

        foreach ($agendas as $agenda) {

            // loop per hari
            $period = CarbonPeriod::create(
                $agenda->tgl_pinjam_usage_room,
                $agenda->tgl_kembali_usage_room
            );


            // 🔹 CASE 1: JAM ADA (BUKAN FULL DAY)
            if ($agenda->jam_mulai_usage_room && $agenda->jam_selesai_usage_room) {
                foreach ($period as $date) {

                    $events[] = [
                        'id' => $agenda->kode_agenda === null ? $agenda->kode_peminjaman : $agenda->kode_agenda,
                        'title' => $agenda->nama_agenda === null ? $agenda->ket_peminjaman : $agenda->nama_agenda,
                        'start' => $date->format('Y-m-d') . ' ' . $agenda->jam_mulai_usage_room,
                        'end'   => $date->format('Y-m-d') . ' ' . $agenda->jam_selesai_usage_room,
                        'allDay' => false,
                        'color' => $this->statusColor($agenda->status_usage_room),
                        'url'   => route('agenda-mhs', $agenda->kode_agenda === null ? $agenda->kode_peminjaman : $agenda->kode_agenda),
                    ];
                }
            }
            // 🔹 CASE 2: JAM NULL (FULL DAY)
            else {

                $events[] = [
                    'id' => $agenda->kode_agenda === null ? $agenda->kode_peminjaman : $agenda->kode_agenda,
                    'title' => $agenda->nama_agenda === null ? $agenda->ket_peminjaman : $agenda->nama_agenda,
                    'start' => $agenda->tgl_pinjam_usage_room,
                    'end'   => $agenda->tgl_kembali_usage_room,
                    // 'allDay' => true,
                    'color' => $this->statusColor($agenda->status_usage_room),
                    'url'   => route('agenda-mhs', $agenda->kode_agenda === null ? $agenda->kode_peminjaman : $agenda->kode_agenda),
                ];
            }
        }

        return response()->json($events);
    }

    private function statusColor($status)
    {
        return match ($status) {
            'diajukan' => '#facc15', // kuning
            'disetujui' => '#22c55e', // hijau
            'selesai' => '#3b82f6', // biru
            'ditolak' => '#ef4444', // merah
            default => '#64748b',
        };
    }
}
