<?php

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

new class extends Component {
    // Fungsi untuk mengambil data agenda
    public function with(): array
    {
        // dd(session()->get('bulan-input'));

        //ambil sesison bulan yg di inputkan user
        $bulanInput = session()->get('bulan-input'); // Ambil bulan dari session atau gunakan bulan saat ini


        $query = DB::table('peminjaman')
            ->select('ket_peminjaman', 'kode_peminjaman', 'tgl_pinjam', 'tgl_kembali')
            ->where('status_peminjaman', 'selesai')
            ->whereMonth('tgl_pinjam', Carbon::parse($bulanInput)->format('m'))
            ->whereYear('tgl_pinjam', Carbon::parse($bulanInput)->format('Y'));

        return [
            'jumlahTransaksi' => $query->count(),
        ];
    }
};
?>

<div wire:poll.10s>
    <div class="flex items-baseline gap-2 mt-1">
        <h3 class="text-3xl font-black text-text-main">{{ $jumlahTransaksi }}</h3>
    </div>
</div>
