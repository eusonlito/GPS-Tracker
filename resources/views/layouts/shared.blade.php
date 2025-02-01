<!doctype html>
<html lang="{{ app()->getLocale() }}" class="bg-gray-200">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="bg-gray-200 text-base text-grey-darkest font-normal relative body-{{ str_replace('.', '-', $ROUTE) }} unauthenticated">
        @if ($device?->shared)

        <a href="{{ route('shared.device', $device->code) }}" class="logo">
            <img src="/build/images/logo.png" alt="Logo">
        </a>

        @else

        <div class="logo">
        <img src="/build/images/logo.png" alt="Logo">
        </div>

        @endif

        @yield ('body')

        @include ('layouts.molecules.footer')
    </body>
</html>
