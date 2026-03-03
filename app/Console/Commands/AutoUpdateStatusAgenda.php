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

        // =================== update status auto untuk peminjaman yang sudah lewat tgl nya tpi blm d acc jadi ditolak =================================
        DB::table('peminjaman')
            ->whereIn('status_peminjaman', ['diajukan'])
            ->where('tgl_pinjam', '<', $today)
            ->update(['status_peminjaman' => 'ditolak']);

        // =================== update status auto untuk peminjaman yang sudah sudah selesai semua di usagenya jadi selesai =====================================
        // khusus unutk peminjaman
        DB::table('peminjaman as p')
            ->whereNotIn('p.status_peminjaman', ['selesai', 'ditolak', 'diajukan'])
            ->whereNotExists(function ($query) use ($today, $currentTime) {
                $query->select(DB::raw(1))
                    ->from('usage_rooms as ur')
                    ->whereRaw('ur.kode_peminjaman = p.kode_peminjaman')
                    ->where(function ($q) use ($today, $currentTime) {
                        // Cari apakah masih ada yang tgl nya hari esok atau nanti
                        $q->where('ur.tgl_pinjam_usage_room', '>', $today)
                            // Atau tgl hari ini tapi jam selesainya belum lewat
                            ->orWhere(function ($sq) use ($today, $currentTime) {
                                $sq->where('ur.tgl_pinjam_usage_room', $today)
                                    ->where(function ($finalQ) use ($currentTime) {
                                        $finalQ->where('ur.jam_selesai_usage_room', '>', $currentTime)
                                            ->orWhereNull('ur.jam_selesai_usage_room'); // Anggap full day belum selesai sampai hari berganti
                                    });
                            });
                    });
            })
            ->whereNotExists(function ($query) use ($today, $currentTime) {
                $query->select(DB::raw(1))
                    ->from('usage_items as ui')
                    ->whereRaw('ui.kode_peminjaman = p.kode_peminjaman')
                    ->where(function ($q) use ($today, $currentTime) {
                        $q->where('ui.tgl_pinjam_usage_item', '>', $today)
                            ->orWhere(function ($sq) use ($today, $currentTime) {
                                $sq->where('ui.tgl_pinjam_usage_item', $today)
                                    ->where(function ($finalQ) use ($currentTime) {
                                        $finalQ->where('ui.jam_selesai_usage_item', '>', $currentTime)
                                            ->orWhereNull('ui.jam_selesai_usage_item');
                                    });
                            });
                    });
            })
            ->update(['p.status_peminjaman' => 'selesai']);

        // ================ membuat semua usage room dan item yg sudah lewat tetapi tidak diguakan auto update slesai ==============================
        // unutk usage room dan item agenda fakultas saja
        DB::table('usage_rooms')
            ->where('kode_peminjaman', NULL)
            ->where('status_usage_room', 'terjadwal')
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tgl_pinjam_usage_room', '<', $today) // Kondisi 1: Tanggal sudah lewat (hari kemarin dll)
                    ->orWhere(function ($q) use ($today, $currentTime) { // Kondisi 2: Hari ini tapi jam sudah lewat
                        $q->where('tgl_pinjam_usage_room', $today)
                            ->whereNotNull('jam_selesai_usage_room')
                            ->where('jam_selesai_usage_room', '<=', $currentTime);
                    });
            })
            ->update(['status_usage_room' => 'selesai']);

        DB::table('usage_items')
            ->where('kode_peminjaman', NULL)
            ->where('status_usage_item', 'terjadwal')
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tgl_pinjam_usage_item', '<', $today) // Tanggal sudah lewat
                    ->orWhere(function ($q) use ($today, $currentTime) { // Hari ini jam lewat
                        $q->where('tgl_pinjam_usage_item', $today)
                            ->whereNotNull('jam_selesai_usage_item')
                            ->where('jam_selesai_usage_item', '<=', $currentTime);
                    });
            })
            ->update(['status_usage_item' => 'selesai']);

        // ======= membuat semua usage room dan item yg sudah lewat tetapi tidak diguakan autou update dibatalkan karna tidak digunakan ===================
        // unutk usage room dan item peminjaman saja
        DB::table('usage_rooms')
            ->where('kode_agenda', NULL)
            ->where('status_usage_room', 'terjadwal')
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tgl_pinjam_usage_room', '<', $today) // Kondisi 1: Tanggal sudah lewat (hari kemarin dll)
                    ->orWhere(function ($q) use ($today, $currentTime) { // Kondisi 2: Hari ini tapi jam sudah lewat
                        $q->where('tgl_pinjam_usage_room', $today)
                            ->whereNotNull('jam_selesai_usage_room')
                            ->where('jam_selesai_usage_room', '<=', $currentTime);
                    });
            })
            ->update(['status_usage_room' => 'dibatalkan']);

        DB::table('usage_items')
            ->where('kode_agenda', NULL)
            ->where('status_usage_item', 'terjadwal')
            ->where(function ($query) use ($today, $currentTime) {
                $query->where('tgl_pinjam_usage_item', '<', $today) // Tanggal sudah lewat
                    ->orWhere(function ($q) use ($today, $currentTime) { // Hari ini jam lewat
                        $q->where('tgl_pinjam_usage_item', $today)
                            ->whereNotNull('jam_selesai_usage_item')
                            ->where('jam_selesai_usage_item', '<=', $currentTime);
                    });
            })
            ->update(['status_usage_item' => 'dibatalkan']);

        // =================================================== khusus angenda fakultas usage room dan item auto update ===================================================
        // ketika jam usage agenda sudah mulai akan update otomatis ke status digunakan,
        // ketika jam ussage agenda sudah selesai akan auto update ke status selesai

        // Update ke 'berlangsung'
        DB::table('usage_rooms')->where('status_usage_room', '=', 'terjadwal')
            ->where('kode_peminjaman', NULL)
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

        // Update ke 'selesai'
        DB::table('usage_rooms')->where('status_usage_room', 'digunakan')
            ->where('kode_peminjaman', NULL)
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


        // khusus agenda fakultas usage item auto update 
        // pdate ke 'berlangsung'
        DB::table('usage_items')->where('status_usage_item', '=', 'terjadwal')
            ->where('kode_peminjaman', NULL)
            ->where('tgl_pinjam_usage_item', $today)
            ->where(function ($query) use ($currentTime) {
                $query->where(function ($q) use ($currentTime) {
                    // Kondisi Agenda Biasa (ada jamnya)
                    $q->whereNotNull('jam_mulai_usage_item')
                        ->where('jam_mulai_usage_item', '<=', $currentTime)
                        ->where('jam_selesai_usage_item', '>', $currentTime);
                })
                    ->orWhere(function ($q) {
                        // Kondisi Agenda Full Day (jam mulai null)
                        // Jika hari ini adalah tanggal pinjam dan jamnya null, anggap berlangsung seharian
                        $q->whereNull('jam_mulai_usage_item');
                    });
            })
            ->update(['status_usage_item' => 'digunakan']);

        // 2. Update ke 'selesai'
        DB::table('usage_items')->where('status_usage_item', 'digunakan')
            ->where('kode_peminjaman', NULL)
            ->where(function ($query) use ($today, $currentTime) {
                // Selesai jika tanggal sudah lewat
                $query->where('tgl_pinjam_usage_item', '<', $today)
                    // Atau tanggalnya hari ini tapi jam selesainya sudah lewat (untuk yang bukan full day)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tgl_pinjam_usage_item', $today)
                            ->whereNotNull('jam_selesai_usage_item')
                            ->where('jam_selesai_usage_item', '<=', $currentTime);
                    });
                // Catatan: Untuk Full Day, biasanya status 'selesai' dipicu saat ganti hari (masuk kondisi poin 1)
            })
            ->update(['status_usage_item' => 'selesai']);


        // ============================================== khusus peminajamn usage room dan item auto update ===============================================
        // keitika jam penggunaan peminjaman sudah selesai tapi belum di acc selesai oleh admin, 
        // maka otomatis akan di update belum kembali oleh sistem

        // usage room
        // Update ke 'selesai'
        DB::table('usage_rooms')->where('status_usage_room', 'diajukan')
            ->where('kode_agenda', NULL)
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
            ->update(['status_usage_room' => 'ditolak']);


        // usage item
        // Update ke 'selesai'
        DB::table('usage_items')->where('status_usage_item', 'diajukan')
            ->where('kode_agenda', NULL)
            ->where(function ($query) use ($today, $currentTime) {
                // Selesai jika tanggal sudah lewat
                $query->where('tgl_pinjam_usage_item', '<', $today)
                    // Atau tanggalnya hari ini tapi jam selesainya sudah lewat (untuk yang bukan full day)
                    ->orWhere(function ($q) use ($today, $currentTime) {
                        $q->where('tgl_pinjam_usage_item', $today)
                            ->whereNotNull('jam_selesai_usage_item')
                            ->where('jam_selesai_usage_item', '<=', $currentTime);
                    });
                // Catatan: Untuk Full Day, biasanya status 'selesai' dipicu saat ganti hari (masuk kondisi poin 1)
            })
            ->update(['status_usage_item' => 'ditolak']);

        
        // Output informasi bahwa proses telah selesai
        $this->info('Status agenda berhasil diperbarui dengan penanganan Full Day.');
    }
}
