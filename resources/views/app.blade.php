<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <link rel="stylesheet" href="https://use.typekit.net/jwb7pmj.css">
        <link rel="stylesheet" href="/css/app.css">
        @yield('head')

    </head>
    <body>
        <div id="app">
            <header>
                <div>
                    <h1><a href="/">Jonny’s Micropub Client</a></h1>
                </div>
                <div>@if(Auth::user())
                        <logout-form action="{{ route('logout') }}" csrf="{{ csrf_token() }}"></logout-form>
@endif

                </div>
            </header>
            <div class="container">@yield('main')</div>
            <footer>
                <p>Running release <code>{{ config('app.version') }}</code></p>
            </footer>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>