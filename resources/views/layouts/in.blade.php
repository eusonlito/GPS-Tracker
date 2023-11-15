<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="main body-{{ str_replace('.', '-', $ROUTE) }} authenticated">
        @include ('layouts.molecules.in-sidebar-mobile')

        <div class="wrapper">
            <div class="wrapper-box">
                @include ('layouts.molecules.in-sidebar')

                <div class="content py-5 md:px-10 md:py-8">
                    <x-message type="error" />
                    <x-message type="success" />

                    @yield ('body')
                </div>
            </div>
        </div>

        @include ('layouts.molecules.footer')
    </body>
</html>
