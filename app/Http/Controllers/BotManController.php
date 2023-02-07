<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Config;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Conversations\ExampleConversation;
use App\Card;
use App\Chat;
use App\CardRequest;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }



    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        $bot->startConversation(new ExampleConversation());
    }

    public function register($bot)
    {
        if ( Chat::where('telegram_id', $bot->getUser()->getId() )->exists() )
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
        $bot->reply("Вы успешно зарегистрированы!");
    }

    public function card(BotMan $bot)
    {
        $lastCardRequest = CardRequest::where('chat_id', $bot->getUser()->getId())
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();

        if ( $lastCardRequest )
        {
            $bot->reply("Вы уже запрашивали карту в течение 24 часов");
            return;
        }

        $card = Card::inRandomOrder()->first();
        if ($card)
        {
            /*CardRequest::create([
                'chat_id' => $bot->getUser()->getId(),
                'card_id' => $card->id,
            ]);*/


            $attachment = new Image(config::get('app.url')."/files/images/{$card->filename}");

            $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

            $bot->reply($message);
            $bot->reply(config::get('app.url')."/files/images/{$card->filename}");

        }
        else
        {
            $bot->reply("Sorry, all images have been sent to you.");
        }
    }
}
