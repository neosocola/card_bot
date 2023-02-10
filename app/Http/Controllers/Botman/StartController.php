<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use App\Conversations\MenuConversation;
use App\Chat;
use App\Setting;

class StartController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }

    public function register($bot)
    {
        if (Chat::where('telegram_id', $bot->getUser()->getId())->exists())
            return;

        Chat::create([
            'telegram_id' => $bot->getUser()->getId(),
            'telegram_firstname' => $bot->getUser()->getFirstName(),
            'telegram_lastname' => $bot->getUser()->getLastName(),
        ]);
    }

    public function start(BotMan $bot)
    {
        $this->register($bot);
        $text = Setting::first()->value('start');
        $bot->reply($text);
        $bot->startConversation(new MenuConversation());
        exit;
    }
}
