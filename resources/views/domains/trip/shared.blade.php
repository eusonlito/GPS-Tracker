@extends ('layouts.out')

@section ('body')

@if ($positions->isNotEmpty())

<div class="box p-5 mt-5">
    <x-map :trip="$row" :positions="$positions"></x-map>
</div>

@endif

@stop
