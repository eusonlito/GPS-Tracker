@extends ('domains.trip.update-layout')

@section ('content')

@if ($positions->isNotEmpty())

<div class="box p-5 mt-5">
    <x-map
        :trip="$row"
        :positions="$positions"
        :alarms="$alarms"
        :notifications="$notifications"
    ></x-map>
</div>

<div class="box mt-5 p-5">
    <x-chart-speed :positions="$positions"></x-chart-speed>
</div>

@endif

@stop
