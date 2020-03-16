<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('header-title')</title>

        <link rel="stylesheet" href="{!! asset(mix('/css/app-back.css', 'back')) !!}">

    </head>
    <body class="gluonAdmin">
        <section class="page" id="app">
            <header>
                <div class="headerContent">
                    <h1>Avignon</h1>
                </div>
            </header>

            <main>


                <div class="mainContent">
                    <h1 class="mainContent__title">@yield('main-title')</h1>
                    @yield('main-content')
                </div>

            </main>

            <aside>
                <div class="asideContent">
                    @yield('aside-content')
                </div>
            </aside>

            <footer>
                <div class="footerContent">

                </div>
            </footer>
        </section>

        <script src="{!! asset(mix('/js/manifest.js', 'back')) !!}"></script>
        <script src="{!! asset(mix('/js/vendor.js', 'back')) !!}"></script>
        <script src="{!! asset(mix('/js/app-back.js', 'back')) !!}"></script>
    </body>
</html>
