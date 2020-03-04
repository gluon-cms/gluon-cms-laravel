<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('page-title')</title>

        <link rel="stylesheet" href="{{ mix('css/app-front.css') }}">

    </head>
    <body class="">
        <section class="page" id="app">

            <header>
            <h1>♠♥♣♦</h1>
            @yield('header-content')
            </header>

            <main>
            @yield('main-content')
            </main>

            <footer>
            @yield('footer-content')
            </footer>
        </section>

        <script src="{{ mix('/js/app-front.js') }}"></script>
    </body>
</html>
