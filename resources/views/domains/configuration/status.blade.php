@extends ('layouts.in')

@section ('body')

<div class="flex items-center justify-center">
    <div class="text-center">
        @if ($updated)

        <div class="box p-10">
            <div class="text-success">@icon('check-circle', 'w-20 h-20')</div>
            <h2 class="mt-5 text-2xl font-medium">{{ __('configuration-status.updated') }}</h2>
        </div>

        <div class="box mb-3 mt-5 px-5 py-3 text-left">
            <div class="font-medium text-success">{{ $current['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $current['date'] }}</div>
        </div>

        @elseif ($available)

        <div class="box p-10">
            <div class="text-warning">@icon('alert-circle', 'w-20 h-20')</div>
            <h2 class="mt-5 text-2xl font-medium">{{ __('configuration-status.available', ['count' => count($log)]) }}</h2>
        </div>

        <div class="box mb-3 mt-5 px-5 py-3 text-left">
            <div class="font-medium text-success">{{ $current['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $current['date'] }}</div>
        </div>

        <div class="w-full border-t border-dashed border-slate-200/60 m-5"></div>

        @foreach ($commits as $commit)

        <div class="box mb-3 px-5 py-3 text-left">
            <div class="font-medium text-warning">{{ $commit['message'] }}</div>
            <div class="mt-0.5 text-xs text-slate-500">{{ $commit['date'] }}</div>
        </div>

        @endforeach

        @if ($more > 0)

        <div class="box mb-3 px-5 py-3 font-medium">
            {{ __('configuration-status.updated-more', ['count' => $more]) }}
        </div>

        @endif

        @else

        <div class="box p-10">
            <div class="text-danger">@icon('x-circle', 'w-20 h-20')</div>
            <h2 class="mt-5 text-2xl font-medium">{{ __('configuration-status.not-available') }}</h2>
            <p class="mt-2">{{ __('configuration-status.not-available-message') }}</p>
        </div>

        @endif
    </div>
</div>

@stop
