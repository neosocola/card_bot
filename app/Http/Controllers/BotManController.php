<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Conversations\ExampleConversation;
use App\Card;
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
            $attachment = new Image(env('APP_URL')."/files1/images/{$card->filename}");

            // Build message object
            $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

            // Reply message object
            $bot->reply($message);

        }
        else
        {
            $bot->reply("Sorry, all images have been sent to you.");
        }
    }
}
