<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use App\Http\Controllers\Controller;
use App\Command;
use App\Chat;
use App\Log;

class CommandController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }



    public function command(BotMan $bot, $command)
    {
        $chat_id = Chat::where('telegram_id', $bot->getUser()->getId())->value('id');
        Log::create([
            'chat_id' => $chat_id,
            'action' => '/'.$command,
        ]);
        $command = Command::where('command', $command)->where('active', 1)->first();

        if ( $command ) {
            $keyboard = Keyboard::create()->type( Keyboard::TYPE_INLINE )
                ->oneTimeKeyboard(true)
                ->addRow(KeyboardButton::create("Запросить карту")->callbackData('/card'))
                ->addRow(KeyboardButton::create("В начало")->callbackData('/start'))
                ->toArray();
            $bot->reply($command->output, $keyboard);
            exit;
        }
    }
}
