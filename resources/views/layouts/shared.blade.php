<!doctype html>
<html lang="{{ app()->getLocale() }}" class="bg-gray-200">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="bg-gray-200 text-base text-grey-darkest font-normal relative body-{{ str_replace('.', '-', $ROUTE) }} unauthenticated">
        @if ($device?->shared)

        <a href="{{ route('shared.device', $device->code) }}" class="logo">
            @svg('build/images/logo.svg')
        </a>

        @else

        <div class="logo">
            @svg('build/images/logo.svg')
        </div>

        @endif

        @yield ('body')

        @include ('layouts.molecules.footer')
    </body>
</html>
