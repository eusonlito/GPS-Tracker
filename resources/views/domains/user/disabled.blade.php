<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="main">
        <div class="container">
            <div class="error-page flex flex-col lg:flex-row items-center justify-center h-screen text-center lg:text-left">
                <div class="lg:mr-20">
                    <img class="h-48 lg:h-auto" src="@asset('build/images/error-illustration.svg')">
                </div>

                <div class="text-white mt-10 lg:mt-0">
                    <div class="text-4xl font-medium">{{ __('user-disabled.message') }}</div>
                    <a href="{{ route('user.auth.credentials') }}" class="btn py-3 px-4 text-white border-white mt-10">{{ __('error.back-home') }}</a>
                </div>
            </div>
        </div>

        @include ('layouts.molecules.footer')
    </body>
</html>
