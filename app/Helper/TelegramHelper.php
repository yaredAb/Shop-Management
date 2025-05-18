<?php

namespace App\Helper;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;

class TelegramHelper
{
    public static function sendTelegramMessage($product, $message) {
        $token = Setting::getValue('telegram_bot_token');
        $chat_id = Setting::getValue('telegram_chat_id');
            Http::post("https://api.telegram.org/bot". $token . "/sendMessage",[
                'chat_id' => $chat_id,
                'text' => $message
            ]);
    }
}
