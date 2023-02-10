<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use App\Conversations\MenuConversation;
use App\Chat;
use App\Setting;

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
        $bot->startConversation(new MenuConversation());
        exit;
    }
}
