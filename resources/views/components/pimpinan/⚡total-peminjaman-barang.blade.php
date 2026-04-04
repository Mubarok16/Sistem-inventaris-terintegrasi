<?php

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

new class extends Component
{
    // Fungsi untuk mengambil data total peminjaman barang
    public function with(): array
    {
        //ambil sesison bulan yg di inputkan user
        $bulanInput = session()->get('bulan-input'); // Ambil bulan dari session atau gunakan bulan saat ini


        $query = DB::table('usage_items')
            ->select('kode_peminjaman','kode_agenda', 'tgl_pinjam_usage_item', 'tgl_kembali_usage_item')
            ->where('status_usage_item', 'selesai')
            ->whereMonth('tgl_pinjam_usage_item', Carbon::parse($bulanInput)->format('m'))
            ->whereYear('tgl_pinjam_usage_item', Carbon::parse($bulanInput)->format('Y'));

        return [
            'jumlahPenggunaanBarang' => $query->count(),
        ];
    }
};
?>

<div wire:poll.10s>
    <div class="flex items-baseline gap-2 mt-1">
        <h3 class="text-3xl font-black text-text-main">{{ $jumlahPenggunaanBarang }}</h3>
    </div>
</div>