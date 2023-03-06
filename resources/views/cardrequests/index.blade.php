@extends('layouts.app')

@section('content')
    <br />
    <div class="alert alert-dark" role="alert">Всего запросов карт: <b id="total">{{ $CardRequests->total() }}</b>
    </div>
    <div class="table-responsive">
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
                        <td>{{ $req->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $CardRequests->links() }}
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">Ещё не было запросов карт =(</div>
        @endif
    </div>
@endsection
