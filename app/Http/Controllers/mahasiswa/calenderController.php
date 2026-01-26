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

        // Ambil data dari Agenda Fakultas
        $agenda_fakultas = DB::table('agenda_fakultas')
            ->join('usage_rooms', 'agenda_fakultas.kode_agenda', '=', 'usage_rooms.kode_agenda')
            ->select(
                'agenda_fakultas.kode_agenda as id_ref',
                'agenda_fakultas.nama_agenda as title_ref',
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.tgl_kembali_usage_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'usage_rooms.status_usage_room'
            )
            ->whereIn('usage_rooms.status_usage_room', ['terjadwal', 'digunakan', 'selesai']);

        // Gabungan (Union) dengan data dari Peminjaman
        $agendas = DB::table('peminjaman')
            ->join('usage_rooms', 'peminjaman.kode_peminjaman', '=', 'usage_rooms.kode_peminjaman')
            ->select(
                'peminjaman.kode_peminjaman as id_ref',
                'peminjaman.ket_peminjaman as title_ref',
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.tgl_kembali_usage_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'usage_rooms.status_usage_room'
            )
            ->union($agenda_fakultas)
            ->whereIn('usage_rooms.status_usage_room', ['terjadwal', 'digunakan', 'selesai'])
            ->get();

        foreach ($agendas as $agenda) {

            // loop per hari
            $period = CarbonPeriod::create(
                $agenda->tgl_pinjam_usage_room,
                $agenda->tgl_kembali_usage_room
            );

            // JAM ADA (BUKAN FULL DAY)
            foreach ($period as $date) {

                $formattedDate = $date->format('Y-m-d');

                if ($agenda->jam_mulai_usage_room && $agenda->jam_selesai_usage_room) {

                    $events[] = [
                        'id' => $agenda->id_ref,
                        'title' => $agenda->title_ref,
                        'start' => $formattedDate . 'T' . $agenda->jam_mulai_usage_room,
                        'end'   => $formattedDate . 'T' . $agenda->jam_selesai_usage_room,
                        'allDay' => false,
                        'color' => $this->statusColor($agenda->status_usage_room, $agenda->id_ref),
                        'url'   => route('agenda-mhs', [
                            urlencode($agenda->id_ref),
                            $date->format('Y-m-d')
                        ]),
                    ];
                }
                // JAM NULL (FULL DAY)
                else {

                    $events[] = [
                        'id' => $agenda->id_ref,
                        'title' => $agenda->title_ref,
                        'start' => $formattedDate,
                        'end'   => $formattedDate,
                        'allDay' => true,
                        'color' => $this->statusColor($agenda->status_usage_room, $agenda->id_ref),
                        'url'   => route('agenda-mhs', [
                            urlencode($agenda->id_ref),
                            $date->format('Y-m-d')
                        ]),
                    ];
                }
            }
        }

        return response()->json($events);
    }

    private function statusColor($status, $id)
    {
        // Cek apakah id ada di tabel peminjaman
        $peminjaman = DB::table('peminjaman')
            ->where('kode_peminjaman', $id)
            ->first();
        // Jika ada, berarti data berasal dari peminjaman
        if ($peminjaman) {

            return match ($status) {
                'terjadwal' => '#facc15', // kuning
                'digunakan' => '#22c55e', // hijau
                default => '#64748b' // abu-abu

            };

        // Jika tidak ada, berarti data berasal dari agenda fakultas
        } else {
            return match ($status) {
                'terjadwal' => '#3b82f6', // biru
                'digunakan' => '#22c55e', // hijau
                default => '#64748b' // abu-abu
            };
        }

    }
}
