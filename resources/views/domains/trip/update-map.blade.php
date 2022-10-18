@extends ('domains.trip.update-layout')

@section ('content')

@if ($positions->isNotEmpty())

<div class="box p-5 mt-5">
    <x-map :id="$row->id" :positions="$positions"></x-map>
</div>

@endif

@stop
