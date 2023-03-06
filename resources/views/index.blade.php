@extends('layouts.app')

@section('content')
    <br />
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Добро пожаловать в панель управления Телеграм ботом!</h1>

    </div>
    <div class="row">
        <p class="muted">В этой панели управления вы можете управлять пользователями и командами вашего телеграм бота, а так же видеть статистику по его использованию
        </p>
    </div>
    <div class="row">
        <div class="alert alert-success" role="alert">Последние 5 зарегистрированных пользователей
        </div>
        @if( count($chats) )
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">Имя</th>
                        <th scope="col">Логин</th>
                        <th scope="col">Получил карт</th>
                        <th scope="col">Зарегистрирован</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ( $chats as $chat )
                        <tr>
                            <td>{{ $chat->telegram_firstname }} {{ $chat->telegram_lastname }}</td>
                            <td>@if ( $chat->telegram_username)<a href="https://t.me/{{$chat->telegram_username}}" target="_blank">&commat;{{$chat->telegram_username}}</a>
                            @else<a href="https://t.me/{{$chat->telegram_id}}" target="_blank">&commat;{{$chat->telegram_id}}</a>@endif</td>
                            <td>{{ $chat->cards_requested }}</td>
                            <td>{{ $chat->created_at }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="alert alert-secondary" role="alert">Всего пользователей в системе: <a href="{{ route('chats.index') }}"><b>{{ $chats_total }}</b></a>
            </div>
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">В системе ещё нет пользователей</div>
        @endif
    </div>
    <div class="row">
        <div class="alert alert-primary" role="alert">Последние 5 запросов карт
        </div>
        @if( count($CardRequests) )
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Пользователь</th>
                    <th>Карта</th>
                    <th>Время запроса</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $CardRequests as $req )
                    <tr>
                        <td>{{ $req->chat->telegram_firstname }} {{ $req->chat->telegram_lastname }}</td>
                        <td><img src="/files/images/{{ $req->card->filename }}" style="max-width: 100px"/></td>
                        <td>
                            {{ $req->created_at }}</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">Ещё не было запросов карт =(</div>
        @endif
    </div>


@endsection
