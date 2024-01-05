@extends ('layouts.in')

@section ('body')

<div class="flex flex-col items-center justify-center lg:h-screen text-center">
    <div class="box p-20">
        @if ($updated)

        <div class="text-success">@icon('check-circle', 'w-20 h-20')</div>
        <h2 class="mt-5 text-2xl font-medium">{{ __('configuration-status.updated') }}</h2>
        <p class="mt-2 font-medium">{{ $remote_commit['message'] }}</p>
        <p class="mt-2">{{ $remote_commit['author']['date'] }}</p>

        @elseif ($available)

        <div class="text-warning">@icon('alert-circle', 'w-20 h-20')</div>
        <h2 class="mt-5 text-2xl font-medium">{{ __('configuration-status.available') }}</h2>
        <p class="mt-2 font-medium">{{ $remote_commit['message'] }}</p>
        <p class="mt-2">{{ $remote_commit['author']['date'] }}</p>

        @else

        <div class="text-danger">@icon('x-circle', 'w-20 h-20')</div>
        <h2 class="mt-5 text-2xl font-medium">{{ __('configuration-status.not-available') }}</h2>
        <p class="mt-2">{{ __('configuration-status.not-available-message') }}<p>

        @endif
    </div>
</div>

@stop
