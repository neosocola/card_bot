<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('resources/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .bg-purple {
            background-color: #755d9a;
        }

        .bi.bi-check-lg {
            color: green;
        }

        .bi.bi-x-lg {
            color: red;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-purple">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index') }}"><i class="bi bi-telegram"></i> Telegram Bot</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Меню</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('chats.index') }}"><i class="bi bi-people-fill"></i> Пользователи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('commands.index') }}"><i class="bi bi-terminal"></i> Команды</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cards.index') }}"><i class="bi bi-card-image"></i> Карты</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cardrequests.index') }}"><i class="bi bi-images"></i> Запросы карт</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logs.index') }}"><i class="bi bi-terminal"></i> Действия пользователей</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('settings.edit') }}"><i class="bi bi-gear"></i> Настройки</a>
                    </li>
                </ul>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="btn btn-success" href="{{ route('password.edit') }}"><i class="bi bi-key-fill"></i> Сменить пароль</a>
                    </li>
                </ul>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                        <a class="btn btn-danger" href="#" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i class="bi bi-box-arrow-right"></i> Выход</a>
                </form>
            </div>
        </div>
    </div>
</nav>



<main role="main" class="container">
    <div class="container">
        @yield('content')
    </div>
</main>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted"></span>
    </div>
</footer>

<script src="{{asset('resources/dist/js/bootstrap.bundle.min.js')}}"></script>
</body>
</html>

