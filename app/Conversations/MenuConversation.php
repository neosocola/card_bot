<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Inspiring;
use App\Http\Controllers\Botman\CardController;


class MenuConversation extends Conversation
{
    public function askMenu()
    {
        $question = Question::create("Что вы хотите сделать?")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('Получить карту')->value('card'),
                Button::create('Получить цитату')->value('quote'),
                Button::create('О нас')->value('about'),
                Button::create('Хочу свой бот')->value('dev'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'card') {
                    return app('App\Http\Controllers\Botman\CardController')->card($this->getBot());
                } else {

                }
            }
        });
    }
    public function run()
    {
        //$this->askMenu();
    }
}
