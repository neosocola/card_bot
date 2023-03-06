@extends('layouts.app')

@section('content')
    <br />
    <div class="alert alert-dark" role="alert">Всего действий пользователей: <b id="total">{{ $logs->total() }}</b>
    </div>
    <div class="text-center alert alert-primary" role="alert">На этой странице представлена информация о всех действиях зарегистрированных пользователей. Если вас интрересует, какие карты получали пользователи - используйте <a href="{{route('cardrequests.index')}}">этот</a> раздел.</div>
    <div class="table-responsive">
        @if( count($logs) )
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Пользователь</th>
                    <th>Действие</th>
                    <th>Время</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $logs as $log )
                    <tr>
                        <td>{{ $log->chat->telegram_firstname }} {{ $log->chat->telegram_lastname }}</td>
                        <td>{{ $log->action }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $logs->links() }}
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">Ещё не было действий среди зарегистрированных пользователей =(</div>
        @endif
    </div>
@endsection
