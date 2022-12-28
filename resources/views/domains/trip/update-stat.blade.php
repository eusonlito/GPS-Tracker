@extends ('domains.trip.update-layout')

@section ('content')

<div class="box p-5 mt-5">
    <div class="p-2">
        <div class="progress h-6">
            <div class="progress-bar p-3" role="progressbar" aria-valuenow="{{ $stats['speed']['max'] }}" aria-valuemin="0" aria-valuemax="100">{{ $stats['speed']['max'] }}</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3" role="progressbar" aria-valuenow="{{ $stats['speed']['avg'] }}" aria-valuemin="0" aria-valuemax="100">{{ $stats['speed']['avg'] }}</div>
        </div>

        <div class="progress h-6 mt-2">
            <div class="progress-bar p-3" role="progressbar" aria-valuenow="{{ $stats['speed']['min'] }}" aria-valuemin="0" aria-valuemax="100">{{ $stats['speed']['min'] }}</div>
        </div>
    </div>
</div>

@stop
