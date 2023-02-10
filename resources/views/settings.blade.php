@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Настройки</h1>
    </div>
    @if ($errors->any())
        <div class="text-center mb-4 alert alert-danger" role="alert">
            @foreach ( $errors->all() as $error )
                {{ $error }}<br />
            @endforeach
        </div>
    @endif
    <form action='{{ route('settings.update') }}' method='post'>
        @csrf
        @method('put')
        <div class="mb-3">
            <label class="form-label" for="start">Ответ пользователю на команду /start</label>
            <textarea class="form-control{{ $errors->has('start') ? ' is-invalid' : '' }}" name="start" rows="10">@if ( old('start') ){{ old('start') }}@else{{ $settings->start }}@endif</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="fallback">Ответ пользователю на неизвестную команду</label>
            <textarea class="form-control{{ $errors->has('fallback') ? ' is-invalid' : '' }}" name="fallback" rows="10">@if ( old('fallback') ){{ old('fallback') }}@else{{ $settings->fallback }}@endif</textarea>
        </div>
        <input class="btn btn-primary btn-lg" type='submit' value='Редактировать'>
    </form>
@endsection
