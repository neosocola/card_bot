<?php

namespace App\Http\Controllers\Botman;

use BotMan\BotMan\BotMan;
use BotMan\Drivers\Telegram\Extensions\Keyboard;
use BotMan\Drivers\Telegram\Extensions\KeyboardButton;
use Illuminate\Support\Facades\Config;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
//use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Card;
use App\Chat;
use App\CardRequest;
use App\Setting;
use App\Log;

class CardController extends Controller
{
    public function handle()
    {
        $botman = app('botman');
        $botman->listen();
    }

    public function card(BotMan $bot)
    {
        $chat_id = Chat::where('telegram_id', $bot->getUser()->getId())->value('id');

        Log::create([
            'chat_id' => $chat_id,
            'action' => '/card'
        ]);

        /*$lastCardRequest = CardRequest::where('chat_id', $chat_id)
            ->where('created_at', '>', Carbon::now()->subHours(24))
            ->first();

        if ( $lastCardRequest ) {
            $bot->reply("Вы уже запрашивали карту ".$lastCardRequest->created_at->diffForHumans().". Запрашивать карту можно только один раз в 24 часа");
            $bot->startConversation(new MenuConversation());
            exit;
        }

        $usedCardIds = CardRequest::where('chat_id', $chat_id)->pluck('card_id');

        $card = Card::whereNotIn('id', $usedCardIds)->inRandomOrder()->first();*/
        $card = Card::inRandomOrder()->first();
        if ($card) {
            CardRequest::create([
                'chat_id' => $chat_id,
                'card_id' => $card->id,
            ]);

            $attachment = new Image(config::get('app.url')."/files/images/{$card->filename}");

            if ( ! $card->description ){
                $text = Setting::first()->value('description');
            }
            else {
                $text = $card->description;
            }

            $message = OutgoingMessage::create($text)
                ->withAttachment($attachment);

            $keyboard = Keyboard::create()->type( Keyboard::TYPE_INLINE )
                ->oneTimeKeyboard(true)
                ->addRow(KeyboardButton::create("Запросить ещё карту")->callbackData('/card'))
                ->addRow(KeyboardButton::create("Помощь по запросу к МАК")->callbackData('/help'))
                ->addRow(KeyboardButton::create("Поддержать ботик")->callbackData('/donate'))
                ->toArray();

            $bot->reply($message, $keyboard);
            Chat::where('telegram_id', $bot->getUser()->getId())->increment('cards_requested');

        }
        else {
            $bot->reply("Извините, вы уже получили все доступные карты");
        }

        exit;
    }
}
