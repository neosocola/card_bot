@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Сменить пароль</h1>
    </div>
    @if ($errors->any())
        <div class="text-center mb-4 alert alert-danger" role="alert">
            @foreach ( $errors->all() as $error )
                {{ $error }}<br />
            @endforeach
        </div>
    @endif
    @if (session('status') === 'password-updated')
        <div class="text-center mb-4 alert alert-success" role="alert">Пароль успешно изменён!</div>
    @endif
    @if (session('error') === 'current-password-invalid')
        <div class="text-center mb-4 alert alert-danger" role="alert">Вы ввели неверный текущий пароль!</div>
    @endif
    @if (session('error') === 'no-new-password')
        <div class="text-center mb-4 alert alert-danger" role="alert">Новый пароль должен отличаться от текущего!</div>
    @endif
    <form action='{{ route('password.update') }}' method='post'>
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="current_password">Введите текущий пароль:</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password">Введите новый пароль:</label>
            <input type="password" name="password" class="form-control" required>
            <small class="form-text text-muted">Не менее 6 символов</small>
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Подтвердите новый пароль:</label>
            <input type="password" name="password_confirmation" class="form-control" required>
            <small class="form-text text-muted">Это нужно, чтобы вы не ошиблись при вводе нового пароля</small>
        </div>
        <input class="btn btn-primary btn-lg" type='submit' value='Изменить'>
    </form>
@endsection
