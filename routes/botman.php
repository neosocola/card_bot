<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\BotMan\StartController;
use App\Http\Controllers\BotMan\CardController;
use App\Http\Controllers\BotMan\CommandController;
use App\Http\Controllers\BotMan\FallbackControllerController;
use App\Http\Middleware\Botman\IsAuth;

$botman = resolve('botman');

$botman->hears('/start', StartController::class.'@start');

$botman->group(['middleware' => new IsAuth()], function ($botman) {
    $botman->hears('/card', CardController::class.'@card');
});

$botman->hears('/([a-z]+)', CommandController::class.'@command');

$botman->fallback(function ($bot) {
    //$bot->reply('Hello!');
    return app('App\Http\Controllers\Botman\FallbackController')->fallback($bot);
});