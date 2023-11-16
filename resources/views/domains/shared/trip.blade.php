@extends ('layouts.shared')

@section ('body')

<div class="my-5">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-1 mb-2">
            <h2 class="box px-5 py-2 mb-5 font-medium text-xl sm:text-2xl">{{ $trip->name }}</h2>
        </div>

        <div class="mb-4 text-center">
            <a href="#" class="btn bg-white mr-2" data-map-live>@icon('play', 'w-8 h-8')</a>
        </div>
    </div>

    @if ($positions->isNotEmpty())

    <div class="box p-5">
        <x-map
            :trip="$trip"
            :positions="$positions"
            :data-map-show-last="$trip->finished()"
            :data-map-positions-url="route('shared.trip', $trip->code)"
        ></x-map>
    </div>

    @endif

    @if ($stats)

    <div class="box p-5 mt-5">
        <h2 class="text-xl font-medium mb-3">{{ __('shared-trip.distance.title') }}</h2>

        <div class="progress h-6">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: 100%" role="progressbar" aria-valuenow="{{ $stats['speed']['max_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.distance.total') }}: @unitHuman('distance', $trip->distance)</div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <h2 class="text-xl font-medium mb-3">{{ __('shared-trip.speed.title') }}</h2>

        <div class="progress h-6">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['max_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['max_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.speed.max') }}: @unitHuman('speed', $stats['speed']['max'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['avg_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['avg_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.speed.avg') }}: @unitHuman('speed', $stats['speed']['avg'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['avg_movement_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['avg_movement_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.speed.avg_movement') }}: @unitHuman('speed', $stats['speed']['avg_movement'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['min_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['min_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.speed.min') }}: @unitHuman('speed', $stats['speed']['min'])</div>
        </div>
    </div>

    <div class="box p-5 my-5">
        <h2 class="text-xl font-medium mb-3">{{ __('shared-trip.time.title') }}</h2>

        <div class="progress h-6">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['time']['total_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['total_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.time.total') }}: @timeHuman($stats['time']['total'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['time']['movement_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['movement_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.time.movement') }}: @timeHuman($stats['time']['movement'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['time']['stopped_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['stopped_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('shared-trip.time.stopped') }}: @timeHuman($stats['time']['stopped'])</div>
        </div>
    </div>

    @endif
</div>

@stop
