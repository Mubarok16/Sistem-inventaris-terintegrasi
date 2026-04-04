<?php

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

new class extends Component {
    /// Fungsi untuk mengambil data total peminjaman barang
    public function with(): array
    {
        //ambil sesison bulan yg di inputkan user
        $bulanInput = session()->get('bulan-input'); // Ambil bulan dari session atau gunakan bulan saat ini

        $query = DB::table('usage_rooms')
            ->leftJoin('agenda_fakultas', 'agenda_fakultas.kode_agenda', '=', 'usage_rooms.kode_agenda')
            ->leftJoin('peminjaman', 'peminjaman.kode_peminjaman', '=', 'usage_rooms.kode_peminjaman')
            ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->select(
                'peminjaman.kode_peminjaman',
                'agenda_fakultas.kode_agenda',
                'agenda_fakultas.nama_agenda', // agenda
                'peminjaman.ket_peminjaman', // agenda
                'usage_rooms.tgl_pinjam_usage_room',
                'usage_rooms.tgl_kembali_usage_room',
                'usage_rooms.jam_mulai_usage_room',
                'usage_rooms.jam_selesai_usage_room',
                'usage_rooms.status_usage_room',
                'rooms.nama_room',
            )
            ->where('usage_rooms.status_usage_room', 'terjadwal')
            ->orderBy('usage_rooms.tgl_pinjam_usage_room', 'desc')
            ->limit(3);
        // ->whereMonth('tgl_pinjam_usage_item', Carbon::parse($bulanInput)->format('m'))
        // ->whereYear('tgl_pinjam_usage_item', Carbon::parse($bulanInput)->format('Y'));

        return [
            'agendaterdekat' => $query->get(),
        ];
    }
};
?>

<tbody wire:poll.10s>
    @forelse ($agendaterdekat as $usageroom)
        <tr class="hover:bg-slate-50 transition-colors border-b border-slate-100"
            wire:key="row-{{ $usageroom->kode_agenda ?? $usageroom->kode_peminjaman }}">

            <td class="px-6 py-3">
                {{-- Isi Kolom Agenda --}}
                <div class="flex items-center gap-3">
                    <div class="size-9 rounded bg-blue-50 text-primary flex items-center justify-center">
                        <i
                            class="fa-solid {{ isset($usageroom->nama_agenda) ? 'fa-graduation-cap' : 'fa-calendar-check' }}"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">
                            {{ $usageroom->nama_agenda ?? $usageroom->ket_peminjaman }}
                        </p>
                    </div>
                </div>
            </td>

            <td class="px-6 py-3 text-slate-700 text-sm">
                Ruang {{ $usageroom->nama_room }}
            </td>

            <td class="px-6 py-3 text-slate-700 text-sm">
                {{ date('d M Y', strtotime($usageroom->tgl_pinjam_usage_room)) }}
                <br>
                <span class="text-[10px] font-bold text-green-700">
                    {{ date('H:i', strtotime($usageroom->jam_mulai_usage_room ?? '00:00')) }} -
                    {{ date('H:i', strtotime($usageroom->jam_selesai_usage_room ?? '23:59')) }}
                </span>
            </td>

            <td class="px-6 py-3">
                <span
                    class="inline-flex px-2 py-1 rounded bg-blue-50 text-blue-700 border border-blue-100 text-[10px] font-bold uppercase">
                    {{ $usageroom->status_usage_room }}
                </span>
            </td>
        </tr>
    @empty
        {{-- Ini kunci agar tulisan empty tidak melompat ke atas --}}
        <tr>
            <td colspan="4" class="px-6 py-4 text-center text-slate-400 italic">
                Tidak ada data tersedia.
            </td>
        </tr>
    @endforelse
</tbody>
