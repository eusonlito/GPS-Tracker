@extends ('layouts.empty')

@section ('body')

<div class="my-5">
    @if ($device->shared)

    <div class="box px-5 py-2 mb-5">
        <a href="{{ route('device.shared', $device->code) }}">&laquo; {{ __('common.back')}}</a>
    </div>

    @endif

    @if ($positions->isNotEmpty())

    <div class="box p-5">
        <x-map :trip="$row" :positions="$positions"></x-map>
    </div>

    @endif

    @if ($stats)

    <div class="box p-5 mt-5">
        <h2 class="text-xl font-medium mb-3">{{ __('trip-shared.distance.title') }}</h2>

        <div class="progress h-6">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: 100%" role="progressbar" aria-valuenow="{{ $stats['speed']['max_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.distance.total') }}: @unitHuman('distance', $row->distance)</div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <h2 class="text-xl font-medium mb-3">{{ __('trip-shared.speed.title') }}</h2>

        <div class="progress h-6">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['max_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['max_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.speed.max') }}: @unitHuman('speed', $stats['speed']['max'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['avg_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['avg_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.speed.avg') }}: @unitHuman('speed', $stats['speed']['avg'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['avg_movement_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['avg_movement_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.speed.avg_movement') }}: @unitHuman('speed', $stats['speed']['avg_movement'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['speed']['min_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['min_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.speed.min') }}: @unitHuman('speed', $stats['speed']['min'])</div>
        </div>
    </div>

    <div class="box p-5 my-5">
        <h2 class="text-xl font-medium mb-3">{{ __('trip-shared.time.title') }}</h2>

        <div class="progress h-6">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['time']['total_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['total_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.time.total') }}: @timeHuman($stats['time']['total'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['time']['movement_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['movement_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.time.movement') }}: @timeHuman($stats['time']['movement'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $stats['time']['stopped_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['stopped_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ __('trip-shared.time.stopped') }}: @timeHuman($stats['time']['stopped'])</div>
        </div>
    </div>

    @endif
</div>

@stop
