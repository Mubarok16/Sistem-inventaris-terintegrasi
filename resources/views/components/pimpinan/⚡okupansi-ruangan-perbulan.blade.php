<?php

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

new class extends Component {
    public function with(): array
    {
        $bulanInput = session()->get('bulan-input'); // Ambil bulan dari session atau gunakan bulan saat ini

        $jumlahRuangan = DB::table('rooms')->count();

        $datokupansi = [];

        $query = DB::table('usage_rooms')
            ->select('kode_agenda', 'kode_peminjaman', 'tgl_pinjam_usage_room', 'tgl_kembali_usage_room', 'jam_mulai_usage_room', 'jam_selesai_usage_room', 'status_usage_room')
            // Pastikan status ini sesuai dengan yang ada di DB Anda
            ->where('status_usage_room', 'selesai')
            ->whereMonth('tgl_pinjam_usage_room', Carbon::parse($bulanInput)->format('m'))
            ->whereYear('tgl_pinjam_usage_room', Carbon::parse($bulanInput)->format('Y'))
            ->get();

        foreach ($query as $value) {
            // Gunakan kode_agenda sebagai kunci jika itu yang ingin Anda tampilkan
            // Jika kode_agenda kosong, baru pakai kode_peminjaman sebagai cadangan
            $key = !empty($value->kode_agenda) ? $value->kode_agenda : $value->kode_peminjaman;

            // Parsing Tanggal
            $tglPinjam = Carbon::parse($value->tgl_pinjam_usage_room)->startOfDay();
            $tglKembali = $value->tgl_kembali_usage_room ? Carbon::parse($value->tgl_kembali_usage_room)->startOfDay() : $tglPinjam;

            $jumlahHari = $tglPinjam->diffInDays($tglKembali) + 1;

            // Logika Perhitungan Jam
            if (empty($value->jam_mulai_usage_room) || empty($value->jam_selesai_usage_room)) {
                $durasiSesi = $jumlahHari * 7;
            } else {
                $jamMulai = Carbon::parse($value->jam_mulai_usage_room);
                $jamSelesai = Carbon::parse($value->jam_selesai_usage_room);

                if ($jumlahHari > 1) {
                    $durasiSesi = $jumlahHari * 7;
                } else {
                    $diff = $jamSelesai->diffInHours($jamMulai);
                    $durasiSesi = max(1, min($diff, 7));
                }
            }

            // SIMPAN KE ARRAY DENGAN PENJUMLAHAN
            if (isset($datokupansi[$key])) {
                $datokupansi[$key]['jumlah_jam_peminjaman'] += $durasiSesi;
            } else {
                $datokupansi[$key] = [
                    'kode_agenda' => $value->kode_agenda,
                    'kode_peminjaman' => $value->kode_peminjaman,
                    'jumlah_jam_peminjaman' => $durasiSesi,
                    'status' => $value->status_usage_room,
                ];
            }
        }

        // 1. Hitung Total Jam Terpakai dari array yang sudah kita buat
        $totalJamTerpakai = array_sum(array_column($datokupansi, 'jumlah_jam_peminjaman'));

        // 2. Tentukan variabel dasar
        // $jumlahRuangan = 5;
        $jamKerjaPerHari = 7;

        // 3. Hitung jumlah hari kerja dalam bulan tersebut
        // Kita ambil bulan dan tahun dari input yang sudah ada
        $date = Carbon::parse($bulanInput);
        $jumlahHariDalamBulan = $date->daysInMonth;

        // Jika Anda ingin mengecualikan hari Sabtu & Minggu (Opsional)
        // $jumlahHariKerja = $date->diffInDaysFiltered(function (Carbon $date) {
        //    return !$date->isWeekend();
        // }, $date->copy()->endOfMonth());
        $jumlahHariHitung = $jumlahHariDalamBulan; // Atau gunakan $jumlahHariKerja jika hanya hari kerja

        // 4. Hitung Total Kapasitas Maksimal
        $totalKapasitasJam = $jumlahRuangan * $jamKerjaPerHari * $jumlahHariHitung;

        // 5. Hitung Persentase Okupansi
        $persentaseOkupansi = $totalKapasitasJam > 0 ? ($totalJamTerpakai / $totalKapasitasJam) * 100 : 0;

        // Pembulatan 2 angka di belakang koma
        $persentaseOkupansi = round($persentaseOkupansi, 2);

        return [
            'detail_per_agenda' => array_values($datokupansi),
            'statistik' => [
                'total_jam_terpakai' => $totalJamTerpakai,
                'total_kapasitas_tersedia' => $totalKapasitasJam,
                'persentase_okupansi' => $persentaseOkupansi . '%',
            ],
            'persentase_okupansi' => $persentaseOkupansi,
        ];

        // Ubah kembali ke array biasa agar mudah dibaca (0, 1, 2...)
        // $hasilAkhir = array_values($datokupansi);

        // dd($hasilAkhir);
    }
};
?>

<div wire:poll.10s>
    {{-- The whole future lies in uncertainty: live immediately. - Seneca --}}
    <div class="flex justify-between items-start mb-4">
        <div class="size-10 bg-blue-50 text-primary rounded-lg flex items-center justify-center">
            <i class="fa-solid fa-door-open"></i>
        </div>
        {{-- <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded">+5.2%</span> --}}
    </div>
    <p class="text-text-muted text-xs font-bold uppercase tracking-wider">Okupansi Ruangan</p>
    <div class="flex items-baseline gap-2 mt-1">
        <h3 class="text-3xl font-black text-text-main">{{ $persentase_okupansi }} %</h3>
        {{-- <livewire:pimpinan.okupansi-ruangan-perbulan /> --}}
    </div>
    <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
        <div class="bg-primary h-full" style="width: {{ $persentase_okupansi }}%"></div>
    </div>
</div>
