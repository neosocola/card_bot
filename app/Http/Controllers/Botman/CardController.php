<?php

namespace App\Http\Controllers\Botman;

use App\Conversations\MenuConversation;
use BotMan\BotMan\BotMan;
use Illuminate\Support\Facades\Config;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Card;
use App\Chat;
use App\CardRequest;

class CardController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }

    public function card(BotMan $bot)
    {
        $ChatRequest = Chat::where('telegram_id', $bot->getUser()->getId())->first();
        $chat_id = $ChatRequest->id;

        $lastCardRequest = CardRequest::where('chat_id', $chat_id)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();

        if ( $lastCardRequest ) {
            $bot->reply("Вы уже запрашивали карту ".$lastCardRequest->created_at->diffForHumans().". Запрашивать карту можно только один раз в 24 часа");
            $bot->startConversation(new MenuConversation());
            exit;
        }

        $usedCardIds = CardRequest::where('chat_id', $chat_id)->pluck('card_id');

        $card = Card::whereNotIn('id', $usedCardIds)->inRandomOrder()->first();
        if ($card) {
            CardRequest::create([
                'chat_id' => $chat_id,
                'card_id' => $card->id,
            ]);

            $attachment = new Image(config::get('app.url')."/files/images/{$card->filename}");

            $message = OutgoingMessage::create('This is my text')
                ->withAttachment($attachment);

            $bot->reply($message);
            $bot->reply(config::get('app.url')."/files/images/{$card->filename}");

        }
        else {
            $bot->reply("Извините, вы уже получили все доступные карты");
        }
        $bot->startConversation(new MenuConversation());

        exit;
    }
}
