<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gluon - Admin</title>

    </head>
    <body>
        <section>
            <header>
                <h1>@yield('page-title')</h1>
            </header>

            <main>
                @yield('main-content')
            </main>

            <aside>
                @yield('aside-content')
            </aside>

            <footer>
                
            </footer>
        </section>
    </body>
</html>
