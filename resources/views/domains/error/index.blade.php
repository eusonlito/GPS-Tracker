<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="main">
        <div class="container">
            <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
                <div class="lg:mr-20">
                    <img alt="{{ $message }}" class="h-48 lg:h-auto" src="@asset('build/images/error-illustration.svg')">
                </div>

                <div class="text-white mt-10 lg:mt-0">
                    <div class="text-8xl font-medium">{{ $code }}</div>
                    <div class="text-xl lg:text-3xl font-medium mt-5">{{ $message }}</div>
                    <a href="{{ route('dashboard.index') }}" class="btn py-3 px-4 text-white border-white mt-10">{{ __('error.back-home') }}</a>
                </div>
            </div>
        </div>

        @include ('layouts.molecules.footer')
    </body>
</html>
