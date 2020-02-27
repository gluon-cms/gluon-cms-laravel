<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gluon - Admin</title>

        <link rel="stylesheet" href="{{mix('css/app.css')}}">

    </head>
    <body class="gluonAdmin">
        <section class="container" id="app">
            <header>
                <div>
                    
                </div>
            </header>

            <main>
                <div class="mainContent">
                    <h1>@yield('page-title')</h1>
                    @yield('main-content')
                </div>
                
            </main>

            <aside>
                <div class="asideContent">
                    @yield('aside-content')
                </div>
            </aside>

            <footer>
                
            </footer>
        </section>

        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
