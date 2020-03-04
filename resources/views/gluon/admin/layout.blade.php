<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('header-title')</title>

        <link rel="stylesheet" href="{{ mix('css/app-back.css') }}">

    </head>
    <body class="gluonAdmin">
        <section class="page" id="app">
            <header>
                <div class="headerContent">
                    <h1>Gluon</h1>
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

        <script src="{{ mix('/js/app-back.js') }}"></script>
    </body>
</html>
