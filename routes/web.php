<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/bot', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'Admin\IndexController@index')->name('index');

    Route::get('/password', 'Admin\PasswordController@edit')->name('password.edit');
    Route::put('/password', 'Admin\PasswordController@update')->name('password.update');

    Route::get('/settings', 'Admin\SettingController@edit')->name('settings.edit');
    Route::put('/settings', 'Admin\SettingController@update')->name('settings.update');

    Route::resource('chats', 'Admin\ChatController')->only('index', 'destroy');
    Route::resource('cardrequests', 'Admin\CardRequestController')->only('index');
    Route::resource('cards', 'Admin\CardController')->except('show');
    Route::resource('commands', 'Admin\CommandController')->except('show');
});
