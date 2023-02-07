@extends('layouts.app')

@section('content')
    <br />
    <div class="alert alert-dark" role="alert">Всего карт в системе: <b id="total">{{ $cards->total() }}</b>
    </div>
    <p><a href="{{ route('cards.create') }}"><button type="button" class="btn btn-primary btn-lg">Добавить карту</button></a></p>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="table-responsive">
        @if( count($cards) )
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Карта</th>
                    <th>Управление</th>
                </tr>
                </thead>
                <tbody>
                @foreach ( $cards as $card )
                    <tr id="card-{{ $card->id }}">
                        <td><img src="/files/images/{{ $card->filename }}" style="max-width: 100px"/></td>
                        <td>
                                <a href=""><span class="badge bg-warning text-dark">Редактировать</span></a>
                            <a href="#" class="delete-card" data-id="{{ $card->id }}"><span class="badge bg-danger text-dark">Удалить</span></a>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $cards->links() }}
        @else
            <div class="text-center mb-4 alert alert-danger" role="alert">В системе ещё нет добавленных карт</div>
        @endif
    </div>
    @if( count($cards) )
    <script>
        $(".delete-card").click(function (e) {
            var id = $(this).data('id');
            e.preventDefault();
            if (confirm("Вы действительно хотите удалить карту?")) {
                $.ajax({
                    type: 'DELETE',
                    url: '/cards/' + id,
                    data: {
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (data) {
                        if (data.success) {
                            $("#card-" + id).remove();
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
