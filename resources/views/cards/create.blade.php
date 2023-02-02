@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Добавить</h1>
    </div>
    @if ($errors->any())
        <div class="text-center mb-4 alert alert-danger" role="alert">
            @foreach ( $errors->all() as $error )
                {{ $error }}<br />
            @endforeach
        </div>
    @endif
    <form action='{{ route('cards.store') }}' enctype='multipart/form-data' method='post'>
        @csrf
        <div class="mb-3">
            <label class="form-label" for="filename">Загрузить карту</label>
            <input type="file" class="form-control form-control-lg{{ $errors->has('filename') ? ' is-invalid' : '' }}" name="filename" id="filename" required>
            <small class="form-text text-muted">Доступные форматы: jpg, jpeg, png, gif</small>
        </div>
        <div class="mb-3">
            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="10">{{ old('description') }}</textarea>
        </div>
        <input class="btn btn-primary btn-lg" type='submit' value='Добавить'>
    </form>
@endsection
