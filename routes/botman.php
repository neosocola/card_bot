<?php
use App\Http\Controllers\BotManController;
use App\Http\Middleware\Botman\IsAuth;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!!!'.$bot->getUser()->getFirstName());
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('/start', BotManController::class.'@start');

//$botman->hears('/card', BotManController::class.'@card')->middleware(new IsAuth());

$botman->group(['middleware' => new IsAuth()], function ($botman) {
    $botman->hears('/card', BotManController::class.'@card');
});


$botman->fallback(function ($bot) {
    $bot->reply('Hello!');
});