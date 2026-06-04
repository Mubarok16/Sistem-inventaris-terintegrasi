<?php

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

new class extends Component {
    public function with(): array
    {
        // Ambil bulan dari session atau gunakan bulan saat ini (Format: YYYY-MM)
        $bulanInput = session()->get('bulan-input', Carbon::now()->format('Y-m'));

        // Hitung total penggunaan ruangan yang statusnya 'selesai' pada bulan tersebut
        $totalPenggunaanSelesai = DB::table('usage_rooms')
            ->where('status_usage_room', 'selesai')
            ->whereMonth('tgl_pinjam_usage_room', Carbon::parse($bulanInput)->format('m'))
            ->whereYear('tgl_pinjam_usage_room', Carbon::parse($bulanInput)->format('Y'))
            ->count();

        return [
            'total_penggunaan' => $totalPenggunaanSelesai,
        ];
    }
};
?>

<div wire:poll.10s>
    <div class="flex justify-between items-start mb-4">
        {{-- Ikon diganti menggunakan fa-calendar-check untuk merepresentasikan kegiatan selesai --}}
        <div class="size-10 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    {{-- Label diubah agar informatif sesuai data baru --}}
    <p class="text-text-muted text-xs font-bold uppercase tracking-wider">Total Ruangan Digunakan</p>

    <div class="flex items-baseline gap-2 mt-1">
        {{-- Menampilkan angka jumlah pemakaian --}}
        <h3 class="text-3xl font-black text-text-main">{{ $total_penggunaan }}</h3>
    </div>
    <p class="text-[10px] text-slate-400 mt-4 font-medium italic">
        Total penggunaan ruangan perbulan.
    </p>
</div>
