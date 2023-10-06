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

@endif

@stop
