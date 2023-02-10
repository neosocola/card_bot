@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Редактировать карту</h1>
    </div>
    @if ($errors->any())
        <div class="text-center mb-4 alert alert-danger" role="alert">
            @foreach ( $errors->all() as $error )
                {{ $error }}<br />
            @endforeach
        </div>
    @endif
    <form action='{{ route('cards.update', $card) }}' method='post'>
        @csrf
        @method('patch')
        <div class="mb-3">
            <img src="/files/images/{{ $card->filename }}" style="max-width: 100px"/>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Описание карты</label>
            <textarea class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" rows="10">@if ( old('description') ){{ old('description') }}@else{{ $card->description }}@endif</textarea>
        </div>
        <input type="hidden" name="page" value="{{ request()->input('page') }}">
        <input class="btn btn-primary btn-lg" type='submit' value='Редактировать'>
    </form>
@endsection
