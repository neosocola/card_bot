<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use App\Http\Controllers\Controller;
use App\Command;

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
        $command = Command::where('command', $command)->where('active', 1)->first();

        if ( $command ) {
            $bot->reply($command->output);
            exit;
        }
    }
}
