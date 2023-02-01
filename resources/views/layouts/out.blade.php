<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="bg-gray-200 h-screen text-base text-grey-darkest font-normal relative body-{{ str_replace('.', '-', $ROUTE) }} unauthenticated">
        @yield ('body')

        @include ('layouts.molecules.footer')
    </body>
</html>
