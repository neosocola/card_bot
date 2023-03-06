@extends('layouts.app')

@section('content')
    <br />
    <div class="alert alert-dark" role="alert">Всего пользователей в системе: <b id="total">{{ $chats->total() }}</b>
    </div>
    <div class="table-responsive">
        @if( count($chats) )
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Имя</th>
                    <th>Логин</th>
                    <th>Зарегистрирован</th>
                    <th>Получил карт</th>
                    <th>Управление</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $chats as $chat )
                    <tr id="chat-{{ $chat->id }}">
                        <td>{{ $chat->telegram_firstname }} {{ $chat->telegram_lastname }}</td>
                        <td>@if ( $chat->telegram_username)<a href="https://t.me/{{$chat->telegram_username}}" target="_blank">&commat;{{$chat->telegram_username}}</a>
                            @else<a href="https://t.me/{{$chat->telegram_id}}" target="_blank">&commat;{{$chat->telegram_id}}</a>@endif</td>
                        <td>{{ $chat->created_at }}</td>
                        <td>{{ $chat->cards_requested }}</td>
                        <td>
                            <a href="#" class="delete-chat" data-id="{{ $chat->id }}"><span class="badge bg-danger text-dark">Удалить</span></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $chats->links() }}
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">В системе ещё нет пользователей</div>
        @endif
    </div>
    @if( count($chats) )
    <script>
        $(".delete-chat").click(function (e) {
            var id = $(this).data('id');
            e.preventDefault();
            if (confirm("Вы действительно хотите удалить пользователя?")) {
                $.ajax({
                    type: 'DELETE',
                    url: '/chats/' + id,
                    data: {
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#chat-" + id).remove();
                            var total = $('#total');
                            total.html(total.html()-1);
                        }
                    }
                });
            }
        });
    </script>
    @endif
@endsection
