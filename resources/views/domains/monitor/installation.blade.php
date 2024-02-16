@extends ('layouts.in')

@section ('body')

<div class="flex items-center justify-center">
    <div class="text-center">
        @if ($updated)

        <div class="box p-10">
            <div class="text-success">@icon('check-circle', 'w-20 h-20')</div>
            <h2 class="mt-5 text-2xl font-medium">{{ __('monitor-installation.updated') }}</h2>
        </div>

        @if ($current)

        <h2 class="mr-5 mt-5 truncate text-lg font-medium">{{ __('monitor-installation.current') }}</h2>

        <div class="box mb-3 mt-5 px-5 py-3 text-left">
            <div class="font-medium text-success">{{ $current['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $current['date'] }}</div>
        </div>

        @endif

        <h2 class="my-5 truncate text-lg font-medium">{{ __('monitor-installation.previous') }}</h2>

        @foreach ($updated_commits as $commit)

        <div class="box mb-3 px-5 py-3 text-left">
            <div class="font-medium text-success">{{ $commit['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $commit['date'] }}</div>
        </div>

        @endforeach

        @elseif ($available)

        <div class="box p-10">
            <div class="text-warning">@icon('alert-circle', 'w-20 h-20')</div>
            <h2 class="mt-5 text-2xl font-medium">{{ __('monitor-installation.available', ['count' => $pending_commits_count]) }}</h2>
        </div>

        <h2 class="mr-5 mt-5 truncate text-lg font-medium">{{ __('monitor-installation.current') }}</h2>

        <div class="box mb-3 mt-5 px-5 py-3 text-left">
            <div class="font-medium text-success">{{ $current['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $current['date'] }}</div>
        </div>

        <h2 class="my-5 truncate text-lg font-medium">{{ __('monitor-installation.pending') }}</h2>

        @foreach ($pending_commits as $commit)

        <div class="box mb-3 px-5 py-3 text-left">
            <div class="font-medium text-warning">{{ $commit['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $commit['date'] }}</div>
        </div>

        @endforeach

        @if ($pending_more)

        <div class="box mb-3 px-5 py-3 font-medium">
            {{ __('monitor-installation.updated-more', ['count' => $pending_more]) }}
        </div>

        @endif

        <h2 class="my-5 truncate text-lg font-medium">{{ __('monitor-installation.previous') }}</h2>

        @foreach ($updated_commits as $commit)

        <div class="box mb-3 px-5 py-3 text-left">
            <div class="font-medium text-success">{{ $commit['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $commit['date'] }}</div>
        </div>

        @endforeach

        @else

        <div class="box p-10">
            <div class="text-danger">@icon('x-circle', 'w-20 h-20')</div>
            <h2 class="mt-5 text-2xl font-medium">{{ __('monitor-installation.not-available') }}</h2>
            <p class="mt-2">{{ __('monitor-installation.not-available-message') }}</p>
        </div>

        @endif
    </div>
</div>

@stop
