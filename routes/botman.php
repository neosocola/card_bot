<?php

use App\Http\Middleware\Botman\IsAuth;

$botman = resolve('botman');

$botman->hears('/start', function ($bot) {
    return app('App\Http\Controllers\Botman\StartController')->start($bot);
});

$botman->group(['middleware' => new IsAuth()], function ($botman) {
    $botman->hears('/card', function ($bot) {
        return app('App\Http\Controllers\Botman\CardController')->card($bot);
    });
});

$botman->hears('/([a-z]+)', function ($bot, $command) {
    return app('App\Http\Controllers\Botman\CommandController')->command($bot, $command);
});

$botman->fallback(function ($bot) {
    return app('App\Http\Controllers\Botman\FallbackController')->fallback($bot);
});