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
        // =================== update status auto untuk peminjaman yang sudah selesai =====================================
        DB::table('peminjaman as p')
            ->where('status_peminjaman', 'terjadwal') // Tambahkan status yang tidak boleh di-auto-selesai
            ->whereNotExists(function ($query) use ($today, $currentTime) {
                $query->select(DB::raw(1))
                    ->from('usage_rooms as ur')
                    ->whereRaw('ur.kode_peminjaman = p.kode_peminjaman')
                    ->where(function ($q) use ($today, $currentTime) {
                        $q->where('ur.tgl_pinjam_usage_room', '>', $today)
                            ->orWhere(function ($sq) use ($today, $currentTime) {
                                $sq->where('ur.tgl_pinjam_usage_room', $today)
                                    ->where(function ($finalQ) use ($currentTime) {
                                        $finalQ->where('ur.jam_selesai_usage_room', '>', $currentTime)
                                            ->orWhereNull('ur.jam_selesai_usage_room');
                                    });
                            })
                            // PERBAIKAN DI SINI: ur, bukan ui. status_usage_room, bukan status_usage_rooms
                            ->orWhere('ur.status_usage_room', 'terlambat');
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
                            })
                            // PERBAIKAN DI SINI: status_usage_item, bukan status_usage_items
                            ->orWhere('ui.status_usage_item', 'terlambat');
                    });
            })
            // PERBAIKAN DI SINI: Hapus p. dari key update
            ->update(['status_peminjaman' => 'selesai']);


        // DB::table('peminjaman as p')
        //     ->whereNotIn('p.status_peminjaman', ['terjadwal'])
        //     ->whereNotExists(function ($query) use ($today, $currentTime) {
        //         $query->select(DB::raw(1))
        //             ->from('usage_rooms as ur')
        //             ->whereRaw('ur.kode_peminjaman = p.kode_peminjaman')
        //             ->where(function ($q) use ($today, $currentTime) {
        //                 // Cari apakah masih ada yang tgl nya hari esok atau nanti
        //                 $q->where('ur.tgl_pinjam_usage_room', '>', $today)
        //                     // Atau tgl hari ini tapi jam selesainya belum lewat
        //                     ->orWhere(function ($sq) use ($today, $currentTime) {
        //                         $sq->where('ur.tgl_pinjam_usage_room', $today)
        //                             ->where(function ($finalQ) use ($currentTime) {
        //                                 $finalQ->where('ur.jam_selesai_usage_room', '>', $currentTime)
        //                                     ->orWhereNull('ur.jam_selesai_usage_room'); // Anggap full day belum selesai sampai hari berganti
        //                             });
        //                     })
        //                     // Kondisi statusnya tercatat 'terlambat'
        //                     ->orWhere('ui.status_usage_rooms', 'terlambat');
        //             });
        //     })
        //     ->whereNotExists(function ($query) use ($today, $currentTime) {
        //         $query->select(DB::raw(1))
        //             ->from('usage_items as ui')
        //             ->whereRaw('ui.kode_peminjaman = p.kode_peminjaman')
        //             ->where(function ($q) use ($today, $currentTime) {
        //                 $q->where('ui.tgl_pinjam_usage_item', '>', $today)
        //                     ->orWhere(function ($sq) use ($today, $currentTime) {
        //                         $sq->where('ui.tgl_pinjam_usage_item', $today)
        //                             ->where(function ($finalQ) use ($currentTime) {
        //                                 $finalQ->where('ui.jam_selesai_usage_item', '>', $currentTime)
        //                                     ->orWhereNull('ui.jam_selesai_usage_item');
        //                             });
        //                     })
        //                     // Kondisi statusnya tercatat 'terlambat'
        //                     ->orWhere('ui.status_usage_items', 'terlambat');
        //             });
        //     })
        //     ->update(['p.status_peminjaman' => 'selesai']);

        // ============= update status auto untuk peminjaman jika ada salah satu usagenya terlambat maka akan di update terlambat ==============
        // khusus unutk peminjaman
        DB::table('peminjaman')
            ->where('status_peminjaman', 'terjadwal')
            ->where(function ($mainQuery) use ($today, $currentTime) {
                $mainQuery->whereExists(function ($q) use ($today, $currentTime) {
                    $q->select(DB::raw(1))
                        ->from('usage_rooms')
                        ->whereColumn('usage_rooms.kode_peminjaman', 'peminjaman.kode_peminjaman')
                        ->where('status_usage_room', '!=', 'selesai')
                        ->where(function ($timeQ) use ($today, $currentTime) {
                            $timeQ->where('tgl_pinjam_usage_room', '<', $today)
                                ->orWhere(function ($sq) use ($today, $currentTime) {
                                    $sq->where('tgl_pinjam_usage_room', $today)
                                        ->where('jam_selesai_usage_room', '<', $currentTime);
                                });
                        });
                })
                    ->orWhereExists(function ($q) use ($today, $currentTime) {
                        $q->select(DB::raw(1))
                            ->from('usage_items')
                            ->whereColumn('usage_items.kode_peminjaman', 'peminjaman.kode_peminjaman')
                            ->where('status_usage_item', '!=', 'selesai')
                            ->where(function ($timeQ) use ($today, $currentTime) {
                                $timeQ->where('tgl_pinjam_usage_item', '<', $today)
                                    ->orWhere(function ($sq) use ($today, $currentTime) {
                                        $sq->where('tgl_pinjam_usage_item', $today)
                                            ->where('jam_selesai_usage_item', '<', $currentTime);
                                    });
                            });
                    });
            })
            ->update(['status_peminjaman' => 'terlambat']);

        // DB::table('peminjaman as p')
        //     ->whereIn('p.status_peminjaman', ['terjadwal']) // Hanya cek yang masih terjadwal
        //     ->where(function ($query) use ($today, $currentTime) {
        //         $query->whereExists(function ($q) use ($today, $currentTime) {
        //             $q->select(DB::raw(1))
        //                 ->from('usage_rooms as ur')
        //                 ->whereColumn('ur.kode_peminjaman', 'p.kode_peminjaman')
        //                 ->where('ur.status_usage_room', '!=', 'selesai') // Pastikan belum selesai
        //                 ->where(function ($timeQ) use ($today, $currentTime) {
        //                     // Terlambat jika: tgl sudah lewat
        //                     $timeQ->where('ur.tgl_pinjam_usage_room', '<', $today)
        //                         // Atau tgl hari ini tapi jam selesai sudah lewat
        //                         ->orWhere(function ($sq) use ($today, $currentTime) {
        //                             $sq->where('ur.tgl_pinjam_usage_room', $today)
        //                                 ->where('ur.jam_selesai_usage_room', '<', $currentTime)
        //                                 ->whereNotNull('ur.jam_selesai_usage_room');
        //                         });
        //                 });
        //         })
        //             // MENGGUNAKAN OR: Salah satu saja terpenuhi (ruangan ATAU barang), maka p.status jadi terlambat
        //             ->orWhereExists(function ($q) use ($today, $currentTime) {
        //                 $q->select(DB::raw(1))
        //                     ->from('usage_items as ui')
        //                     ->whereColumn('ui.kode_peminjaman', 'p.kode_peminjaman')
        //                     ->where('ui.status_usage_item', '!=', 'selesai')
        //                     ->where(function ($timeQ) use ($today, $currentTime) {
        //                         $timeQ->where('ui.tgl_pinjam_usage_item', '<', $today)
        //                             ->orWhere(function ($sq) use ($today, $currentTime) {
        //                                 $sq->where('ui.tgl_pinjam_usage_item', $today)
        //                                     ->where('ui.jam_selesai_usage_item', '<', $currentTime)
        //                                     ->whereNotNull('ui.jam_selesai_usage_item');
        //                             });
        //                     });
        //             });
        //     })
        //     ->update(['p.status_peminjaman' => 'terlambat']);

        // ================ membuat semua usage room dan item yg sudah lewat tetapi tidak diguakan auto update slesai ==============================
        // unutk usage room dan item di agenda fakultas saja
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

        // ======= membuat semua usage room dan item yg sudah lewat tetapi tidak diguakan auto update dibatalkan karna tidak digunakan ===================
        // unutk usage room dan item di peminjaman saja
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
        // keitika jam penggunaan peminjaman sudah selesai tapi barang atu ruangan belum kembali (belum konfirmasi selesai di admin), 
        // maka otomatis akan di update belum kembali oleh sistem

        // usage room
        // Update ke 'selesai'
        DB::table('usage_rooms')->where('status_usage_room', 'digunakan')
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
            ->update(['status_usage_room' => 'terlambat']);


        // usage item
        // Update ke 'selesai'
        DB::table('usage_items')->where('status_usage_item', 'digunakan')
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
            ->update(['status_usage_item' => 'terlambat']);


        // Output informasi bahwa proses telah selesai
        $this->info('Status agenda berhasil diperbarui dengan penanganan Full Day.');
    }
}
