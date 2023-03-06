<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use App\Http\Controllers\Controller;
use App\Chat;
use App\Setting;
use App\Log;


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
            'telegram_username' => $bot->getUser()->getUsername(),
        ]);
    }

    public function start(BotMan $bot)
    {
        $this->register($bot);

        $text = Setting::first()->value('start');
        $text = str_replace("{name}", $bot->getUser()->getFirstName(), $text);

        $keyboard = Keyboard::create()->type( Keyboard::TYPE_INLINE )
            ->oneTimeKeyboard(true)
            ->addRow(KeyboardButton::create("Инструкция по работе с МАК")->callbackData('/help'))
            ->addRow(KeyboardButton::create("Запросить карту")->callbackData('/card'))
            ->addRow(KeyboardButton::create("Узнать больше об Александре")->callbackData('/about'))
            ->addRow(KeyboardButton::create("Написать Александре")->callbackData('/message'))
            ->addRow(KeyboardButton::create("Поддержать ботик")->callbackData('/donate'))
            ->addRow(KeyboardButton::create("Хочу свой бот")->callbackData('/dev'))
            ->toArray();

        $bot->reply($text, $keyboard);

        $chat_id = Chat::where('telegram_id', $bot->getUser()->getId())->value('id');
        Log::create([
            'chat_id' => $chat_id,
            'action' => '/start'
        ]);
        exit;
    }
}
