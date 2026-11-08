<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $secret = (string) config('services.telegram.webhook_secret');
        $providedSecret = (string) $request->header('X-Telegram-Bot-Api-Secret-Token');

        if ($secret === '' || $providedSecret === '' || !hash_equals($secret, $providedSecret)) {
            return response()->json(['ok' => false], 403);
        }

        $message = $request->input('message');
        $chatId = data_get($message, 'chat.id');
        $chatType = data_get($message, 'chat.type');
        $text = trim((string) data_get($message, 'text', ''));

        if (!$chatId || $chatType !== 'private') {
            return response()->json(['ok' => true]);
        }

        $command = strtolower(strtok($text, " \t\n"));
        if (!in_array($command, ['/start', '/id', '/start@notif_sipra_bot', '/id@notif_sipra_bot'], true)) {
            return response()->json(['ok' => true]);
        }

        $token = config('services.telegram.token');
        if (blank($token)) {
            Log::error('Telegram webhook cannot reply because TELEGRAM_BOT_TOKEN is missing.');
            return response()->json(['ok' => true]);
        }

        $chatId = (string) $chatId;
        $reply = "Halo! Selamat datang di Bot Notifikasi SIPRA Fakultas Teknik.\n\n"
            . "Telegram ID Anda adalah:\n<code>{$chatId}</code>\n\n"
            . "Salin ID tersebut, lalu masukkan pada kolom ID Telegram di profil admin/staff SIPRA.\n"
            . "Gunakan perintah /id kapan saja untuk melihat ID ini kembali.";

        try {
            $response = Http::timeout(10)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $reply,
                'parse_mode' => 'HTML',
            ]);

            if (!$response->successful() || !$response->json('ok')) {
                Log::warning('Telegram bot reply failed.', [
                    'chat_id' => $chatId,
                    'http_status' => $response->status(),
                    'telegram_description' => $response->json('description'),
                ]);
            }
        } catch (Throwable $exception) {
            Log::warning('Telegram bot reply request failed.', [
                'chat_id' => $chatId,
                'error' => $exception->getMessage(),
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
