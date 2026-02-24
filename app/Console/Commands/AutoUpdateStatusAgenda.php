<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AutoUpdateStatusAgenda extends Command
{
    // Nama perintah yang akan dipanggil nanti
    // protected $signature = 'agenda:update-status';
    // protected $description = 'Mengubah status agenda menjadi berlangsung atau selesai otomatis';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-update-status-agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengubah status usage_room dan usage_item menjadi digunakan atau selesai otomatis berdasarkan waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $today = $now->toDateString();
        $currentTime = $now->toTimeString();

        // 1. Update ke 'berlangsung'
        DB::table('usage_rooms')->where('status_usage_room', '=', 'terjadwal')
            ->where('tgl_pinjam_usage_room', $today)
            ->where(function ($query) use ($currentTime) {
                $query->where(function ($q) use ($currentTime) {
                    // Kondisi Agenda Biasa (ada jamnya)
                    $q->whereNotNull('jam_mulai_usage_room')
                        ->where('jam_mulai_usage_room', '<=', $currentTime)
                        ->where('jam_selesai_usage_room', '>', $currentTime);
                })
                    ->orWhere(function ($q) {
                        // Kondisi Agenda Full Day (jam mulai null)
                        // Jika hari ini adalah tanggal pinjam dan jamnya null, anggap berlangsung seharian
                        $q->whereNull('jam_mulai_usage_room');
                    });
            })
            ->update(['status_usage_room' => 'digunakan']);

        // 2. Update ke 'selesai'
        DB::table('usage_rooms')->where('status_usage_room', 'digunakan')
            ->where(function ($query) use ($today, $currentTime) {
                // Selesai jika tanggal sudah lewat
                $query->where('tgl_pinjam_usage_room', '<', $today)
                    // Atau tanggalnya hari ini tapi jam selesainya sudah lewat (untuk yang bukan full day)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tgl_pinjam_usage_room', $today)
                            ->whereNotNull('jam_selesai_usage_room')
                            ->where('jam_selesai_usage_room', '<=', $currentTime);
                    });
                // Catatan: Untuk Full Day, biasanya status 'selesai' dipicu saat ganti hari (masuk kondisi poin 1)
            })
            ->update(['status_usage_room' => 'selesai']);

        $this->info('Status agenda berhasil diperbarui dengan penanganan Full Day.');
    }
}
