<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PublicAgendaController extends Controller
{
    /**
     * Public, read-only calendar feed. Only faculty agenda records are exposed;
     * private borrowing requests and borrower identities are intentionally excluded.
     */
    public function events(): JsonResponse
    {
        $events = collect();
        $statuses = ['terjadwal', 'digunakan'];

        // Public feed intentionally contains no borrower names or identity data.
        // Include both faculty agenda usage and borrowing usage for rooms/items.
        $sources = [
            [
                'table' => 'usage_rooms', 'date_start' => 'tgl_pinjam_usage_room',
                'date_end' => 'tgl_kembali_usage_room', 'time_start' => 'jam_mulai_usage_room',
                'time_end' => 'jam_selesai_usage_room', 'status' => 'status_usage_room',
                'code' => 'kode_agenda', 'source' => 'agenda',
            ],
            [
                'table' => 'usage_items', 'date_start' => 'tgl_pinjam_usage_item',
                'date_end' => 'tgl_kembali_usage_item', 'time_start' => 'jam_mulai_usage_item',
                'time_end' => 'jam_selesai_usage_item', 'status' => 'status_usage_item',
                'code' => 'kode_agenda', 'source' => 'agenda',
            ],
        ];

        foreach ($sources as $source) {
            $query = DB::table($source['table'] . ' as u')
                ->whereIn('u.' . $source['status'], $statuses)
                ->whereNotNull('u.' . $source['date_start'])
                ->whereNotNull('u.' . $source['date_end'])
                ->whereNotNull('u.' . $source['code']);

            $rows = (clone $query)
                ->join('agenda_fakultas as a', 'u.' . $source['code'], '=', 'a.kode_agenda')
                ->select(
                    'a.kode_agenda as event_code',
                    'a.nama_agenda as event_title',
                    'a.tipe_agenda as event_type',
                    'u.' . $source['date_start'] . ' as starts_at',
                    'u.' . $source['date_end'] . ' as ends_at',
                    'u.' . $source['time_start'] . ' as starts_time',
                    'u.' . $source['time_end'] . ' as ends_time',
                    'u.' . $source['status'] . ' as event_status'
                )
                ->get()
                ->map(fn ($row) => (object) array_merge((array) $row, ['event_source' => 'agenda']));

            $events = $events->concat($rows);
        }

        // Borrowing rows have kode_peminjaman, not kode_agenda. Do not inner-join
        // them to faculty agenda: doing so was the reason bookings disappeared.
        $borrowingSources = [
            [
                'table' => 'usage_rooms', 'date_start' => 'tgl_pinjam_usage_room',
                'date_end' => 'tgl_kembali_usage_room', 'time_start' => 'jam_mulai_usage_room',
                'time_end' => 'jam_selesai_usage_room', 'status' => 'status_usage_room',
            ],
            [
                'table' => 'usage_items', 'date_start' => 'tgl_pinjam_usage_item',
                'date_end' => 'tgl_kembali_usage_item', 'time_start' => 'jam_mulai_usage_item',
                'time_end' => 'jam_selesai_usage_item', 'status' => 'status_usage_item',
            ],
        ];

        foreach ($borrowingSources as $source) {
            $rows = DB::table($source['table'] . ' as u')
                ->join('peminjaman as p', 'u.kode_peminjaman', '=', 'p.kode_peminjaman')
                ->whereIn('u.' . $source['status'], $statuses)
                ->whereNotNull('u.' . $source['date_start'])
                ->whereNotNull('u.' . $source['date_end'])
                ->select(
                    'p.kode_peminjaman as event_code',
                    'p.ket_peminjaman as event_title',
                    DB::raw("'Peminjaman' as event_type"),
                    'u.' . $source['date_start'] . ' as starts_at',
                    'u.' . $source['date_end'] . ' as ends_at',
                    'u.' . $source['time_start'] . ' as starts_time',
                    'u.' . $source['time_end'] . ' as ends_time',
                    'u.' . $source['status'] . ' as event_status'
                )
                ->get()
                ->map(fn ($row) => (object) array_merge((array) $row, ['event_source' => 'peminjaman']));

            $events = $events->concat($rows);
        }

        $result = collect();
        $seen = [];

        foreach ($events as $event) {
            try {
                $start = Carbon::parse($event->starts_at)->startOfDay();
                $end = Carbon::parse($event->ends_at)->startOfDay();
            } catch (\Throwable $exception) {
                continue;
            }

            if ($end->lt($start)) {
                continue;
            }

            foreach (CarbonPeriod::create($start, $end) as $date) {
                $dateString = $date->format('Y-m-d');
                $startTime = $event->starts_time ? substr((string) $event->starts_time, 0, 8) : null;
                $endTime = $event->ends_time ? substr((string) $event->ends_time, 0, 8) : null;
                $hasTime = $startTime && $endTime;
                $dedupeKey = implode('|', [$event->event_source, $event->event_code, $dateString, $startTime ?: '', $endTime ?: '']);

                if (isset($seen[$dedupeKey])) {
                    continue;
                }
                $seen[$dedupeKey] = true;

                $result->push([
                    'id' => $event->event_source . '-' . $event->event_code . '-' . $dateString . '-' . ($startTime ?: 'all-day'),
                    'title' => $event->event_title ?: ($event->event_source === 'peminjaman' ? 'Peminjaman Sarana' : 'Agenda Fakultas'),
                    'start' => $hasTime ? $dateString . 'T' . $startTime : $dateString,
                    'end' => $hasTime ? $dateString . 'T' . $endTime : $date->copy()->addDay()->format('Y-m-d'),
                    'allDay' => !$hasTime,
                    'backgroundColor' => $this->agendaColor($event->event_type),
                    'borderColor' => $this->agendaColor($event->event_type),
                    'extendedProps' => [
                        'kode_agenda' => $event->event_code,
                        'sumber' => $event->event_source,
                        'tipe_agenda' => $event->event_type ?: 'Agenda Fakultas',
                        'status' => $event->event_status,
                        'tanggal' => $dateString,
                        'detail_url' => $event->event_source === 'peminjaman'
                            ? null
                            : route('agenda-publik.detail', [
                                'kode_agenda' => $event->event_code,
                                'tanggal' => $dateString,
                            ]),
                    ],
                ]);
            }
        }

        return response()->json($result->values());
    }

    /**
     * Public event detail. The response contains agenda and asset schedule
     * information only, never borrower names, identity numbers, or private notes.
     */
    public function detail(string $kode_agenda, string $tanggal): JsonResponse
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $tanggal)->toDateString();
        } catch (\Throwable $exception) {
            return response()->json(['message' => 'Tanggal tidak valid.'], 422);
        }

        $agenda = DB::table('agenda_fakultas')
            ->select('kode_agenda', 'nama_agenda', 'tipe_agenda', 'tgl_mulai_agenda', 'tgl_selesai_agenda')
            ->where('kode_agenda', $kode_agenda)
            ->first();

        if (!$agenda) {
            return response()->json(['message' => 'Agenda tidak ditemukan.'], 404);
        }

        $rooms = DB::table('usage_rooms as u')
            ->join('rooms as r', 'u.id_room', '=', 'r.id_room')
            ->where('u.kode_agenda', $kode_agenda)
            ->whereIn('u.status_usage_room', ['terjadwal', 'digunakan', 'selesai'])
            ->whereDate('u.tgl_pinjam_usage_room', '<=', $date)
            ->whereDate('u.tgl_kembali_usage_room', '>=', $date)
            ->select('r.nama_room', 'u.jam_mulai_usage_room as jam_mulai', 'u.jam_selesai_usage_room as jam_selesai', 'u.status_usage_room as status')
            ->get()
            ->map(fn ($row) => [
                'nama' => $row->nama_room,
                'jam_mulai' => $row->jam_mulai ? substr((string) $row->jam_mulai, 0, 5) : null,
                'jam_selesai' => $row->jam_selesai ? substr((string) $row->jam_selesai, 0, 5) : null,
                'status' => $row->status,
            ]);

        $items = DB::table('usage_items as u')
            ->join('items as i', 'u.id_item', '=', 'i.id_item')
            ->where('u.kode_agenda', $kode_agenda)
            ->whereIn('u.status_usage_item', ['terjadwal', 'digunakan', 'selesai'])
            ->whereDate('u.tgl_pinjam_usage_item', '<=', $date)
            ->whereDate('u.tgl_kembali_usage_item', '>=', $date)
            ->select('i.nama_item', 'i.merek_model', 'r.nama_room as tempat_simpan', 'u.qty_usage_item', 'u.jam_mulai_usage_item as jam_mulai', 'u.jam_selesai_usage_item as jam_selesai', 'u.status_usage_item as status')
            ->join('rooms as r', 'i.id_room', '=', 'r.id_room')
            ->get()
            ->map(fn ($row) => [
                'nama' => trim($row->nama_item . ' ' . ($row->merek_model ?? '')),
                'tempat_simpan' => $row->tempat_simpan,
                'jumlah' => (int) $row->qty_usage_item,
                'jam_mulai' => $row->jam_mulai ? substr((string) $row->jam_mulai, 0, 5) : null,
                'jam_selesai' => $row->jam_selesai ? substr((string) $row->jam_selesai, 0, 5) : null,
                'status' => $row->status,
            ]);

        return response()->json([
            'kode_agenda' => $agenda->kode_agenda,
            'nama_agenda' => $agenda->nama_agenda,
            'tipe_agenda' => $agenda->tipe_agenda ?: 'Agenda Fakultas',
            'tanggal' => $date,
            'tanggal_mulai' => $agenda->tgl_mulai_agenda,
            'tanggal_selesai' => $agenda->tgl_selesai_agenda,
            'ruangan' => $rooms->values(),
            'barang' => $items->values(),
        ]);
    }

    private function agendaColor(?string $type): string
    {
        $type = mb_strtolower((string) $type);

        if (str_contains($type, 'peminjaman')) {
            return '#0f766e';
        }

        // KBM, seminar, rapat, dan agenda fakultas lainnya memakai satu kategori warna.
        return '#2563eb';
    }
}
