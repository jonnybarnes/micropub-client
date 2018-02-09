<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="/css/app.css">

        @yield('head')
    </head>
    <body>
        <div id="app">
            <nav class="navbar">
                <div class="navbar-brand">
                    <h1 class="is-size-2">Micropub Client</h1>
                </div>
                @if(Auth::user())<div class="navbar-end">
                    <div class="navbar-item">
                        <logout-form action="{{ route('logout') }}" csrf="{{ csrf_token() }}"></logout-form>
                    </div>
                </div>@endif
            </nav>
            <div class="container">@yield('main')</div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>