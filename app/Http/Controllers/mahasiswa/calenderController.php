<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class calenderController extends Controller
{

    /// unutk menampilkan semua data agenda di dalamkalender
    public function calender()
    {
        // Deteksi prefix di Controller
        // $prefix = request()->is('admin/*') ? 'admin' : 'peminjam';
        $prefix = request()->segment(1);
        $routeName = $prefix;

        // dd($routeName);

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
        // }

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
                        'url'   => route($routeName . '.agenda-calender', [
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
                        'url'   => route($routeName . '.agenda-calender', [
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
                'selesai' => '#99A7BB', // abu abu
                default => '#64748b' // abu-abu
            };

            // Jika tidak ada, berarti data berasal dari agenda fakultas
        } else {
            return match ($status) {
                'terjadwal' => '#3b82f6', // biru
                'digunakan' => '#22c55e', // hijau
                'selesai' => '#99A7BB', // hijau
                default => '#64748b' // abu-abu
            };
        }
    }

    // unutk menampilkan satu agenda atau peminjaman
    public function calenderSpesifikAgendaDanPeminjaman()
    {

        // Ambil data dari Agenda Fakultas
        $agenda_fakultas = DB::table('agenda_fakultas')
            ->leftJoin('usage_rooms', 'agenda_fakultas.kode_agenda', '=', 'usage_rooms.kode_agenda')
            ->leftJoin('usage_items', 'agenda_fakultas.kode_agenda', '=', 'usage_items.kode_agenda')
            ->select(
                'agenda_fakultas.kode_agenda as id_ref',
                'agenda_fakultas.nama_agenda as title_ref',

                // 'usage_rooms.tgl_pinjam_usage_room',
                // 'usage_rooms.tgl_kembali_usage_room',
                // 'usage_rooms.jam_mulai_usage_room',
                // 'usage_rooms.jam_selesai_usage_room',
                // 'usage_rooms.status_usage_room'

                DB::raw('COALESCE(usage_rooms.tgl_pinjam_usage_room, usage_items.tgl_pinjam_usage_item) as tgl_pinjam_usage_room'),
                DB::raw('COALESCE(usage_rooms.tgl_kembali_usage_room, usage_items.tgl_kembali_usage_item) as tgl_kembali_usage_room'),

                // Gabungkan jam: jika room ada pakai room, jika tidak pakai item
                DB::raw('COALESCE(usage_rooms.jam_mulai_usage_room, usage_items.jam_mulai_usage_item) as jam_mulai_usage_room'),
                DB::raw('COALESCE(usage_rooms.jam_selesai_usage_room, usage_items.jam_selesai_usage_item) as jam_selesai_usage_room'),

                // Gabungkan status
                DB::raw('COALESCE(usage_rooms.status_usage_room, usage_items.status_usage_item) as status_usage_room')
            )
            ->where('agenda_fakultas.kode_agenda', '=', session('id_peminjaman_agenda'))
            ->distinct()
            // ->whereIn('usage_rooms.status_usage_room', ['terjadwal', 'digunakan', 'selesai'])
            ->get();

        // Peminjaman
        $agendas = DB::table('peminjaman')
            ->leftJoin('usage_rooms', 'peminjaman.kode_peminjaman', '=', 'usage_rooms.kode_peminjaman')
            ->leftJoin('usage_items', 'peminjaman.kode_peminjaman', '=', 'usage_items.kode_peminjaman')
            ->select(
                // 'peminjaman.kode_peminjaman as id_ref',
                // 'peminjaman.ket_peminjaman as title_ref',

                // 'usage_rooms.tgl_pinjam_usage_room',
                // 'usage_rooms.tgl_kembali_usage_room',
                // 'usage_rooms.jam_mulai_usage_room',
                // 'usage_rooms.jam_selesai_usage_room',
                // 'usage_rooms.status_usage_room',

                // 'usage_items.tgl_pinjam_usage_item',
                // 'usage_items.tgl_kembali_usage_item',
                // 'usage_items.jam_mulai_usage_item',
                // 'usage_items.jam_selesai_usage_item',
                // 'usage_items.status_usage_item'

                'peminjaman.kode_peminjaman as id_ref',
                'peminjaman.ket_peminjaman as title_ref',

                // Gabungkan tanggal: jika room ada pakai room, jika tidak pakai item
                DB::raw('COALESCE(usage_rooms.tgl_pinjam_usage_room, usage_items.tgl_pinjam_usage_item) as tgl_pinjam_usage_room'),
                DB::raw('COALESCE(usage_rooms.tgl_kembali_usage_room, usage_items.tgl_kembali_usage_item) as tgl_kembali_usage_room'),

                // Gabungkan jam: jika room ada pakai room, jika tidak pakai item
                DB::raw('COALESCE(usage_rooms.jam_mulai_usage_room, usage_items.jam_mulai_usage_item) as jam_mulai_usage_room'),
                DB::raw('COALESCE(usage_rooms.jam_selesai_usage_room, usage_items.jam_selesai_usage_item) as jam_selesai_usage_room'),

                // Gabungkan status
                DB::raw('COALESCE(usage_rooms.status_usage_room, usage_items.status_usage_item) as status_usage_room')
            )
            ->where('peminjaman.kode_peminjaman', '=', session('id_peminjaman_agenda'))
            ->distinct()
            // ->whereIn('usage_rooms.status_usage_room', ['terjadwal', 'digunakan', 'selesai'])
            ->get();
        // }

        // dd($agendas, $agenda_fakultas);



        if ($agendas->isNotEmpty()) {
            // jika yg di click user itu peminjaman
            // dd($agendas);

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
                            'color' => $this->statusColorPeminjamanAgenda($agenda->status_usage_room, $agenda->id_ref),
                            'url'   => route('admin' . '.agenda-calender', [
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
                            'color' => $this->statusColorPeminjamanAgenda($agenda->status_usage_room, $agenda->id_ref),
                            'url'   => route('admin' . '.agenda-calender', [
                                urlencode($agenda->id_ref),
                                $date->format('Y-m-d')
                            ]),
                        ];
                    }
                }
            }

            return response()->json($events);
        } else {
            // jika agenda
            // dd('agenda');

            foreach ($agenda_fakultas as $agenda) {

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
                            'color' => $this->statusColorPeminjamanAgenda($agenda->status_usage_room, $agenda->id_ref),
                            'url'   => route('admin' . '.agenda-calender', [
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
                            'color' => $this->statusColorPeminjamanAgenda($agenda->status_usage_room, $agenda->id_ref),
                            'url'   => route('admin' . '.agenda-calender', [
                                urlencode($agenda->id_ref),
                                $date->format('Y-m-d')
                            ]),
                        ];
                    }
                }
            }
            return response()->json($events);
        }

        // dd($agendas);

        // foreach ($agendas as $agenda) {

        //     // loop per hari
        //     $period = CarbonPeriod::create(
        //         $agenda->tgl_pinjam_usage_room,
        //         $agenda->tgl_kembali_usage_room
        //     );

        //     // JAM ADA (BUKAN FULL DAY)
        //     foreach ($period as $date) {

        //         $formattedDate = $date->format('Y-m-d');

        //         if ($agenda->jam_mulai_usage_room && $agenda->jam_selesai_usage_room) {

        //             $events[] = [
        //                 'id' => $agenda->id_ref,
        //                 'title' => $agenda->title_ref,
        //                 'start' => $formattedDate . 'T' . $agenda->jam_mulai_usage_room,
        //                 'end'   => $formattedDate . 'T' . $agenda->jam_selesai_usage_room,
        //                 'allDay' => false,
        //                 'color' => $this->statusColor($agenda->status_usage_room, $agenda->id_ref),
        //                 'url'   => route($routeName . '.agenda-calender', [
        //                     urlencode($agenda->id_ref),
        //                     $date->format('Y-m-d')
        //                 ]),
        //             ];
        //         }
        //         // JAM NULL (FULL DAY)
        //         else {

        //             $events[] = [
        //                 'id' => $agenda->id_ref,
        //                 'title' => $agenda->title_ref,
        //                 'start' => $formattedDate,
        //                 'end'   => $formattedDate,
        //                 'allDay' => true,
        //                 'color' => $this->statusColor($agenda->status_usage_room, $agenda->id_ref),
        //                 'url'   => route($routeName . '.agenda-calender', [
        //                     urlencode($agenda->id_ref),
        //                     $date->format('Y-m-d')
        //                 ]),
        //             ];
        //         }
        //     }
        // }

        // return response()->json($events);
    }

    private function statusColorPeminjamanAgenda($status, $id)
    {
        // Cek apakah id ada di tabel peminjaman
        $peminjaman = DB::table('peminjaman')
            ->where('kode_peminjaman', $id)
            ->first();
        // Jika ada, berarti data berasal dari peminjaman
        if ($peminjaman) {
            return match ($status) {
                'diajukan' => '#964B00', // coklat
                'terlambat' => '#FF0000', // red
                'dibatalkan' => '#6B7280', // abu abu
                'terjadwal' => '#facc15', // kuning
                'digunakan' => '#3b82f6', // biru
                'selesai' => '#22c55e', // hijau
                default => '#64748b' // abu-abu
            };

            // Jika tidak ada, berarti data berasal dari agenda fakultas
        } else {
            return match ($status) {
                'terjadwal' => '#3b82f6', // biru
                'digunakan' => '#22c55e', // hijau
                'selesai' => '#99A7BB', // hijau
                // default => '#64748b' // abu-abu
            };
        }
    }
}
