@extends ('domains.trip.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <div class="p-2">
        <div class="progress h-6">
            <div class="progress-bar p-3" style="width: {{ $stats['speed']['max_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['max_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ $stats['speed']['max'] }}km/h</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3" style="width: {{ $stats['speed']['avg_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['avg_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ $stats['speed']['avg'] }}km/h</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3" style="width: {{ $stats['speed']['min_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['speed']['min_percent'] }}" aria-valuemin="0" aria-valuemax="100">{{ $stats['speed']['min'] }}km/h</div>
        </div>
    </div>
</div>

<div class="box p-5 mt-5">
    <div class="p-2">
        <div class="progress h-6">
            <div class="progress-bar p-3" style="width: {{ $stats['time']['total_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['total_percent'] }}" aria-valuemin="0" aria-valuemax="100">@timeHuman($stats['time']['total'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3" style="width: {{ $stats['time']['movement_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time'][movement_percent'] }}" aria-valuemin="0" aria-valuemax="100">@timeHuman($stats['time']['movement'])</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3" style="width: {{ $stats['time']['stopped_percent'] }}%" role="progressbar" aria-valuenow="{{ $stats['time']['stopped_percent'] }}" aria-valuemin="0" aria-valuemax="100">@timeHuman($stats['time']['stopped'])</div>
        </div>
    </div>
</div>

@stop
