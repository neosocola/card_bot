<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use App\Chat;
use App\Setting;
use App\Log;

class FallbackController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }
    public function fallback(BotMan $bot)
    {
        $text = Setting::first()->value('fallback');
        $bot->reply($text);
        $chat_id = Chat::where('telegram_id', $bot->getUser()->getId())->value('id');
        Log::create([
            'chat_id' => $chat_id,
            'action' => 'fallback'
        ]);
        exit;
    }
}
