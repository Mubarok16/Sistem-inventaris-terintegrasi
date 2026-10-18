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

        $roomUsages = DB::table('agenda_fakultas as a')
            ->join('usage_rooms as u', 'a.kode_agenda', '=', 'u.kode_agenda')
            ->select(
                'a.kode_agenda',
                'a.nama_agenda',
                'a.tipe_agenda',
                'u.tgl_pinjam_usage_room as starts_at',
                'u.tgl_kembali_usage_room as ends_at',
                'u.jam_mulai_usage_room as starts_time',
                'u.jam_selesai_usage_room as ends_time',
                'u.status_usage_room as status'
            )
            ->whereIn('u.status_usage_room', ['terjadwal', 'digunakan', 'selesai'])
            ->get();

        $itemUsages = DB::table('agenda_fakultas as a')
            ->join('usage_items as u', 'a.kode_agenda', '=', 'u.kode_agenda')
            ->select(
                'a.kode_agenda',
                'a.nama_agenda',
                'a.tipe_agenda',
                'u.tgl_pinjam_usage_item as starts_at',
                'u.tgl_kembali_usage_item as ends_at',
                'u.jam_mulai_usage_item as starts_time',
                'u.jam_selesai_usage_item as ends_time',
                'u.status_usage_item as status'
            )
            ->whereIn('u.status_usage_item', ['terjadwal', 'digunakan', 'selesai'])
            ->get();

        foreach ($roomUsages->concat($itemUsages) as $usage) {
            if (!$usage->starts_at || !$usage->ends_at) {
                continue;
            }

            $start = Carbon::parse($usage->starts_at)->startOfDay();
            $end = Carbon::parse($usage->ends_at)->startOfDay();

            if ($end->lt($start)) {
                continue;
            }

            foreach (CarbonPeriod::create($start, $end) as $date) {
                $dateString = $date->format('Y-m-d');
                $hasTime = !empty($usage->starts_time) && !empty($usage->ends_time);
                $startValue = $hasTime ? $dateString . 'T' . substr((string) $usage->starts_time, 0, 8) : $dateString;
                $endValue = $hasTime ? $dateString . 'T' . substr((string) $usage->ends_time, 0, 8) : $date->copy()->addDay()->format('Y-m-d');

                $key = implode('|', [
                    $usage->kode_agenda,
                    $dateString,
                    $hasTime ? substr((string) $usage->starts_time, 0, 8) : 'all-day',
                    $hasTime ? substr((string) $usage->ends_time, 0, 8) : 'all-day',
                ]);

                // An agenda can reserve both rooms and items; show one calendar block
                // when their date and time range are identical.
                if ($events->contains(fn ($event) => $event['id'] === $key)) {
                    continue;
                }

                $events->push([
                    'id' => $key,
                    'title' => $usage->nama_agenda,
                    'start' => $startValue,
                    'end' => $endValue,
                    'allDay' => !$hasTime,
                    'backgroundColor' => $this->agendaColor($usage->tipe_agenda),
                    'borderColor' => $this->agendaColor($usage->tipe_agenda),
                    'extendedProps' => [
                        'kode_agenda' => $usage->kode_agenda,
                        'tipe_agenda' => $usage->tipe_agenda ?: 'Agenda Fakultas',
                        'status' => $usage->status,
                        'tanggal' => $dateString,
                        'detail_url' => route('agenda-publik.detail', [
                            'kode_agenda' => $usage->kode_agenda,
                            'tanggal' => $dateString,
                        ]),
                    ],
                ]);
            }
        }

        return response()->json($events->values());
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
