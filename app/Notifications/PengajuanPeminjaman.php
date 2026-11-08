<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class PengajuanPeminjaman extends Notification
{
    use Queueable;

    protected $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    /**
     * Kita gunakan channel 'database' atau 'mail' bawaan agar Laravel tidak error,
     * lalu kita selipkan pengiriman Telegram di dalam method ini.
     */
    public function via(object $notifiable): array
    {
        // 1. Jalankan fungsi kirim ke Telegram secara manual di sini
        // $this->kirimTembakTelegram();

        $this->kirimTembakTelegram($notifiable->routes['telegram']);

        // 2. Kembalikan channel bawaan Laravel yang Anda inginkan (misal mail, atau database)
        // Jika tidak ingin kirim email/database, kosongkan saja array-nya []
        return []; 
    }

    /**
     * Fungsi kustom untuk menembak API Telegram langsung tanpa package
     */
    private function kirimTembakTelegram($chatId)
    // private function kirimTembakTelegram()
    {
        $token = config('services.telegram.token');
        // $chatId = env('TELEGRAM_CHAT_ID');

        if (blank($token) || blank($chatId)) {
            Log::warning('Telegram notification skipped: bot token or chat ID is missing.');
            return;
        }

        // Kolom no_hp lama bertipe decimal; hilangkan akhiran desimal agar Telegram menerima chat ID integer.
        $chatId = str_contains((string) $chatId, '.')
            ? rtrim(rtrim((string) $chatId, '0'), '.')
            : (string) $chatId;

        // Menyusun template pesan text biasa (Markdown)
        $pesan = "*🚨 PERMOHONAN PENGAJUAN PEMINJAMAN 🚨*\n\n"
               . "Ada pengajuan peminjaman baru yang memerlukan persetujuan:\n"
               . "--------------------------------------------------\n"
               . "*kode:* " . $this->peminjaman['kode_peminjaman'] . "\n"
               . "*nama peminjam:* " . $this->peminjaman['nama_user'] . "\n"
               . "*keterangan peminjaman:* " . $this->peminjaman['keterangan_peminjaman'] . "\n"
               . "*tanggal_pinjam:* " . $this->peminjaman['tanggal_pinjam'] . "\n"
               . "*tanggal_kembali:* " . $this->peminjaman['tanggal_kembali'] . "\n"
               . "--------------------------------------------------\n"
               . "[Lihat & Setujui Pengajuan](" . url('admin/pengajuan-peminjaman/detail/' . $this->peminjaman['kode_peminjaman']) . ")";

        // Tembak API Telegram menggunakan HTTP Client bawaan Laravel
        try {
            $response = Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $pesan,
                'parse_mode' => 'Markdown',
            ]);

            if (!$response->successful() || !$response->json('ok')) {
                Log::warning('Telegram notification failed.', [
                    'chat_id' => $chatId,
                    'http_status' => $response->status(),
                    'telegram_description' => $response->json('description'),
                ]);
            }
        } catch (Throwable $exception) {
            Log::warning('Telegram notification request failed.', [
                'chat_id' => $chatId,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}