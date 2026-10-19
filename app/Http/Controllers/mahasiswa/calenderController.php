<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class calenderController extends Controller
{

    /// unutk menampilkan semua data agenda di dalamkalender
    public function calender()
    {
        $prefix = request()->segment(1);
        $routeName = $prefix === 'peminjam' ? 'peminjam' : $prefix;

        // Fetch room and item schedules separately. A borrowing may contain
        // only items, only rooms, or both, so a room-only join hides valid events.
        $statuses = ['terjadwal', 'digunakan'];

        $agendaRooms = DB::table('agenda_fakultas as a')
            ->join('usage_rooms as u', 'a.kode_agenda', '=', 'u.kode_agenda')
            ->whereIn('u.status_usage_room', $statuses)
            ->whereNotNull('u.tgl_pinjam_usage_room')
            ->whereNotNull('u.tgl_kembali_usage_room')
            ->selectRaw("a.kode_agenda as id_ref, a.nama_agenda as title_ref,
                u.tgl_pinjam_usage_room as starts_at, u.tgl_kembali_usage_room as ends_at,
                u.jam_mulai_usage_room as starts_time, u.jam_selesai_usage_room as ends_time,
                u.status_usage_room as status_ref, 'agenda' as source_ref")
            ->get();

        $agendaItems = DB::table('agenda_fakultas as a')
            ->join('usage_items as u', 'a.kode_agenda', '=', 'u.kode_agenda')
            ->whereIn('u.status_usage_item', $statuses)
            ->whereNotNull('u.tgl_pinjam_usage_item')
            ->whereNotNull('u.tgl_kembali_usage_item')
            ->selectRaw("a.kode_agenda as id_ref, a.nama_agenda as title_ref,
                u.tgl_pinjam_usage_item as starts_at, u.tgl_kembali_usage_item as ends_at,
                u.jam_mulai_usage_item as starts_time, u.jam_selesai_usage_item as ends_time,
                u.status_usage_item as status_ref, 'agenda' as source_ref")
            ->get();

        $borrowingRooms = DB::table('peminjaman as p')
            ->join('usage_rooms as u', 'p.kode_peminjaman', '=', 'u.kode_peminjaman')
            ->whereIn('u.status_usage_room', $statuses)
            ->whereNotNull('u.tgl_pinjam_usage_room')
            ->whereNotNull('u.tgl_kembali_usage_room')
            ->selectRaw("p.kode_peminjaman as id_ref, p.ket_peminjaman as title_ref,
                u.tgl_pinjam_usage_room as starts_at, u.tgl_kembali_usage_room as ends_at,
                u.jam_mulai_usage_room as starts_time, u.jam_selesai_usage_room as ends_time,
                u.status_usage_room as status_ref, 'peminjaman' as source_ref")
            ->get();

        $borrowingItems = DB::table('peminjaman as p')
            ->join('usage_items as u', 'p.kode_peminjaman', '=', 'u.kode_peminjaman')
            ->whereIn('u.status_usage_item', $statuses)
            ->whereNotNull('u.tgl_pinjam_usage_item')
            ->whereNotNull('u.tgl_kembali_usage_item')
            ->selectRaw("p.kode_peminjaman as id_ref, p.ket_peminjaman as title_ref,
                u.tgl_pinjam_usage_item as starts_at, u.tgl_kembali_usage_item as ends_at,
                u.jam_mulai_usage_item as starts_time, u.jam_selesai_usage_item as ends_time,
                u.status_usage_item as status_ref, 'peminjaman' as source_ref")
            ->get();

        $events = [];
        $seen = [];

        foreach ($agendaRooms->concat($agendaItems)->concat($borrowingRooms)->concat($borrowingItems) as $schedule) {
            try {
                $start = \Carbon\Carbon::parse($schedule->starts_at)->startOfDay();
                $end = \Carbon\Carbon::parse($schedule->ends_at)->startOfDay();
            } catch (\Throwable $exception) {
                continue;
            }

            if ($end->lt($start)) {
                continue;
            }

            foreach (CarbonPeriod::create($start, $end) as $date) {
                $dateString = $date->format('Y-m-d');
                $startTime = $schedule->starts_time ? substr((string) $schedule->starts_time, 0, 8) : null;
                $endTime = $schedule->ends_time ? substr((string) $schedule->ends_time, 0, 8) : null;
                $hasTime = $startTime && $endTime;
                $dedupeKey = implode('|', [$schedule->source_ref, $schedule->id_ref, $dateString, $startTime ?: '', $endTime ?: '']);

                // Room and item rows belonging to the same booking/event and slot
                // should not create duplicate blocks in the calendar.
                if (isset($seen[$dedupeKey])) {
                    continue;
                }
                $seen[$dedupeKey] = true;

                $event = [
                    'id' => $schedule->source_ref . '-' . $schedule->id_ref . '-' . $dateString,
                    'title' => $schedule->title_ref ?: ($schedule->source_ref === 'peminjaman' ? 'Peminjaman Sarana' : 'Agenda Fakultas'),
                    'start' => $hasTime ? $dateString . 'T' . $startTime : $dateString,
                    'end' => $hasTime ? $dateString . 'T' . $endTime : $date->copy()->addDay()->format('Y-m-d'),
                    'allDay' => !$hasTime,
                    'color' => $this->statusColor($schedule->status_ref, $schedule->id_ref),
                    'url' => route($routeName . '.agenda-calender', [
                        urlencode($schedule->id_ref),
                        $dateString,
                    ]),
                ];
                $events[] = $event;
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
                'dibatalkan' => '#64748B', // abu tua
                'selesai' => '#99A7BB', // abu abu
                default => '#64748b' // abu-abu
            };

            // Jika tidak ada, berarti data berasal dari agenda fakultas
        } else {
            return match ($status) {
                'terjadwal' => '#3b82f6', // biru
                'digunakan' => '#22c55e', // hijau
                'dibatalkan' => '#64748B', // abu tua
                'selesai' => '#99A7BB', // abu abu
                default => '#64748b' // abu-abu
            };
        }
    }

    // unutk menampilkan satu agenda atau peminjaman
    public function calenderSpesifikAgendaDanPeminjaman()
    {

        $user = Auth::user()->hak_akses;

        if ($user == 'admin') {
            $prefix = 'admin';
        }elseif ($user == 'mahasiswa') {
            $prefix = 'peminjam';
        }elseif ($user == 'kapordi') {
            $prefix = 'kaprodi';
        }elseif ($user == 'pimpinan') {
            $prefix = 'pimpinan';
        }

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
                            'url'   => route($prefix . '.agenda-calender', [
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
                            'url'   => route($prefix . '.agenda-calender', [
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
                            'url'   => route($prefix . '.agenda-calender', [
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
                            'url'   => route($prefix . '.agenda-calender', [
                                urlencode($agenda->id_ref),
                                $date->format('Y-m-d')
                            ]),
                        ];
                    }
                }
            }
            return response()->json($events);
        }
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
                'dibatalkan' => '#64748b', // abu-abu
                default => '#64748b',
            };
        }
    }
}
