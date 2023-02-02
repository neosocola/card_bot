<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!!!'.$bot->getUser()->getFirstName());
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('/card', BotManController::class.'@card');

$botman->fallback(function ($bot) {
    $bot->reply('Hello!');
});