@extends('layouts.guest')

@section('content')
    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <form action="{{ route('login') }}" method="POST" class="form-signin">
        @csrf
        <div class="text-center mb-4">
            <h1 class="h3 mb-3 font-weight-normal">Авторизация в системе</h1>
        </div>
        @if ($errors->any())
            <div class="text-center mb-4 alert alert-danger" role="alert">
                @foreach ( $errors->all() as $error )
                    {{ $error }}<br />
                @endforeach
            </div>
        @endif
        <div class="form-label-group">
            <input type="text" name="login" id="inputLogin" class="form-control" value="{{ old('login') }}" placeholder="Логин" required>
            <label for="inputLogin">Введите логин</label>
        </div>
        <div class="form-label-group">
            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Пароль" required>
            <label for="inputPassword">Введите пароль</label>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" name="remember_me" id="remember_me" checked>
            <label class="form-check-label" for="remember_me">Запомнить меня</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary btn-block" type="submit">Войти</button><br /><br />
    </form>
@endsection
