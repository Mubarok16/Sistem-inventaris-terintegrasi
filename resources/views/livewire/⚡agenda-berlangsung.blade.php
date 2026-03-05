<?php

use Livewire\Component;

new class extends Component {
    // properti untuk menampung batas data
    public ?int $limit = null;

    // Fungsi untuk mengambil data agenda
    public function with(): array
    {

        $query = DB::table('usage_rooms')
            ->leftJoin('agenda_fakultas', 'usage_rooms.kode_agenda', '=', 'agenda_fakultas.kode_agenda')
            ->leftJoin('peminjaman', 'usage_rooms.kode_peminjaman', '=', 'peminjaman.kode_peminjaman')
            ->leftJoin('rooms', 'usage_rooms.id_room', '=', 'rooms.id_room')
            ->select('usage_rooms.kode_peminjaman', 'usage_rooms.kode_agenda', 'rooms.nama_room', 'usage_rooms.tgl_pinjam_usage_room', 'usage_rooms.jam_mulai_usage_room', 'usage_rooms.jam_selesai_usage_room', 'agenda_fakultas.nama_agenda', 'peminjaman.ket_peminjaman')
            ->whereDate('usage_rooms.tgl_pinjam_usage_room', now()->format('Y-m-d'))
            ->where('usage_rooms.status_usage_room', 'digunakan');

        // Jika properti $limit diisi, batasi hasilnya
        if ($this->limit) {
            $query->take($this->limit);
        }

        return [
            'Agendaberlangsung' => $query->get(),
        ];
    }
};
?>

<div wire:poll.10s>
    <div class="flex flex-wrap gap-3 mb-4">
        @forelse ($Agendaberlangsung as $agenda)
            <div class="flex gap-4 group p-2 rounded-lg border border-slate-100 hover:bg-blue-50 transition-colors cursor-pointer"
                onclick="window.location='{{ route('admin.details-content:agenda-berlangsung', ['id' => urlencode($agenda->kode_agenda ?? $agenda->kode_peminjaman)]) }}'">
                <div
                    class="flex-shrink-0 w-12 h-14 bg-slate-50 border border-slate-100 rounded-lg flex flex-col items-center justify-center">
                    <span
                        class="text-[10px] font-bold text-slate-400 uppercase">{{ date('M', strtotime($agenda->tgl_pinjam_usage_room)) }}</span>
                    <span
                        class="text-lg font-black text-primary leading-none">{{ date('d', strtotime($agenda->tgl_pinjam_usage_room)) }}</span>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold text-slate-900 group-hover:text-primary transition-colors">
                        {{ $agenda->nama_agenda ?? $agenda->ket_peminjaman }}</p>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <i class="fa-regular fa-clock text-[14px] text-blue-500"></i>
                        @if ($agenda->jam_mulai_usage_room && $agenda->jam_selesai_usage_room)
                            {{ date('H:i', strtotime($agenda->jam_mulai_usage_room)) }} -
                            {{ date('H:i', strtotime($agenda->jam_selesai_usage_room)) }}
                        @else
                            Full day
                        @endif
                    </p>
                    <p class="text-xs text-slate-500 flex items-center gap-1">
                        <i class="fa-solid fa-building text-[14px] text-blue-500"></i>
                        Ruang {{ $agenda->nama_room }}
                    </p>
                </div>
            </div>
        @empty
            <div class="w-full! text-center py-4">
                <div class="">
                    <i class="fa-solid fa-calendar-xmark text-3xl text-red-300"></i>
                </div>
                <div class="text-slate-400 text-sm">Tidak ada agenda berlangsung</div>
            </div>
        @endforelse
    </div>
</div>
