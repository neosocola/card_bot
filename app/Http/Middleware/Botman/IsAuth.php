<?php

namespace App\Http\Middleware\Botman;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Matching;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

use App\Chat;

class IsAuth implements Matching
{
    public function matching(IncomingMessage $message, $pattern, $regexMatched)
    {
        global $bot;

        if ( Chat::where('telegram_id', $message->getSender() )->exists() )
            return true;

        return false;

    }

}


