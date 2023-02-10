@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@if ($edit)Редактировать@elseДобавить@endif команду</h1>
    </div>
    @if ($errors->any())
        <div class="text-center mb-4 alert alert-danger" role="alert">
            @foreach ( $errors->all() as $error )
                {{ $error }}<br />
            @endforeach
        </div>
    @endif
    <form action='@if ($edit){{ route('commands.update', $command) }}@else{{ route('commands.store') }}@endif' method='post'>
        @csrf
        @if ($edit)@method('patch')@endif
        <div class="mb-3">
            <label for="command">Название команды</label>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">/</span>
                <input type="text" name="command" value="@if(old('command')){{ old('command') }}@else{{ $command->command }}@endif" class="form-control{{ $errors->has('command') ? ' is-invalid' : '' }}" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label" for="output">Ответ пользователю</label>
            <textarea class="form-control{{ $errors->has('output') ? ' is-invalid' : '' }}" name="output" rows="10">@if ( old('output') ){{ old('output') }}@else{{ $command->output }}@endif</textarea>
        </div>
        <div class="mb-3 form-check form-switch">
            <input class="form-check-input" type="checkbox" name="active" role="switch" id="flexSwitchCheckChecked" @if ($command->active) checked @endif>
            <label class="form-check-label" for="flexSwitchCheckChecked">Команда активна?</label>
        </div>
        <input type="hidden" name="page" value="{{ request()->input('page') }}">
        <input class="btn btn-primary btn-lg" type='submit' value='@if($edit)Редактировать@elseДобавить@endif'>
    </form>
@endsection
