@extends('layouts.app')

@section('content')
    <br />
    <div class="alert alert-dark" role="alert">Всего команд в системе: <b id="total">{{ $commands->total() }}</b>
    </div>
    <p><a href="{{ route('commands.create', ['page' => $commands->currentPage()] ) }}"><button type="button" class="btn btn-primary btn-lg">Добавить команду</button></a></p>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        @if( count($commands) )
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Команда</th>
                    <th>Активна</th>
                    <th>Управление</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $commands as $command )
                    <tr id="command-{{ $command->id }}">
                        <td>/{{ $command->command }}</td>
                        <td>
                            @if ($command->active)
                                <i class="bi bi-check-lg"></i>
                            @else
                                <i class="bi bi-x-lg"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('commands.edit', ['command' => $command, 'page' => $commands->currentPage()]) }}"><span class="badge bg-warning text-dark">Редактировать</span></a>
                            <a href="#" class="delete-command" data-id="{{ $command->id }}"><span class="badge bg-danger text-dark">Удалить</span></a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $commands->links() }}
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">В системе ещё нет добавленных команд</div>
        @endif
    </div>
    @if( count($commands) )
    <script>
        $(".delete-command").click(function (e) {
            var id = $(this).data('id');
            e.preventDefault();
            if (confirm("Вы действительно хотите удалить команду?")) {
                $.ajax({
                    type: 'DELETE',
                    url: '/commands/' + id,
                    data: {
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#command-" + id).remove();
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
