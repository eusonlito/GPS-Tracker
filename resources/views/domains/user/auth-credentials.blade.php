@extends ('layouts.out')

@section ('body')

<div class="flex flex-col h-screen justify-center items-center">
    <div class="logo">
        @svg('build/images/logo.svg')
    </div>

    <div class="w-11/12 md:w-8/12 xl:w-2/5 bg-white bg-grey-lightest px-10 py-10 rounded shadow">
        <form method="post">
            <x-message type="error" class="mb-5" />

            <input type="hidden" name="_action" value="authCredentials">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            <div class="mb-3">
                <input type="text" class="border w-full p-3" name="email" placeholder="{{ __('user-auth-credentials.email') }}" autofocus required>
            </div>

            <div class="mb-6">
                <input type="password" class="border w-full p-3" name="password" placeholder="{{ __('user-auth-credentials.password') }}" required>
            </div>

            <div class="mt-5 xl:mt-8 text-center">
                <button type="submit" class="btn btn-primary py-3 px-5 whitespace-nowrap">{{ __('user-auth-credentials.login') }}</button>
            </div>
        </form>
    </div>
</div>

@stop
