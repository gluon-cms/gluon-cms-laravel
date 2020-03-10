<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('page-title')</title>

        <link rel="stylesheet" href="{!! asset(mix('/css/app-front.css', 'front')) !!}">

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
        <script src="{!! asset(mix('/js/manifest.js', 'front')) !!}"></script>
        <script src="{!! asset(mix('/js/vendor.js', 'front')) !!}"></script>
        <script src="{!! asset(mix('/js/app-front.js', 'front')) !!}"></script>

    </body>
</html>
