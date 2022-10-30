@extends ('layouts.in')

@section ('body')

@if ($devices->isEmpty())

<img class="m-auto mt-10 lg:mt-20 h-60" src="@asset('build/images/device.svg')">

<div class="mt-10 text-center">
    <a href="{{ route('device.create') }}" class="btn bg-white py-3 px-4">{{ __('dashboard-index.device-create') }}</a>
</div>

@elseif ($trips->isEmpty())

<img class="m-auto mt-10 lg:mt-20 h-60" src="@asset('build/images/trip.svg')">

<div class="mt-10 text-center">
    <div class="text-xl lg:text-2xl font-medium">{{ __('dashboard-index.trip-wating') }}</div>
</div>

@else

<form>
    <div class="lg:flex lg:space-x-4">
        @if ($devices->count() > 1)

        <div class="flex-1 mb-4">
            <x-select name="device_id" :options="$devices" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-1 mb-4">
            <x-select name="trip_id" :options="$trips" value="id" text="name" data-change-submit></x-select>
        </div>

        <div class="mb-4 text-center">
            <a href="#" class="btn bg-white mr-2" data-map-live>@icon('play', 'w-4 h-4 sm:w-6 sm:h-6')</a>
            <a href="{{ route('trip.update', $trip->id) }}" class="btn bg-white mr-2">@icon('edit', 'w-4 h-4 sm:w-6 sm:h-6')</a>
            <a href="{{ route('trip.update.map', $trip->id) }}" class="btn bg-white mr-2">@icon('map', 'w-4 h-4 sm:w-6 sm:h-6')</a>
            <a href="{{ route('trip.update.position', $trip->id) }}" class="btn bg-white mr-2">@icon('map-pin', 'w-4 h-4 sm:w-6 sm:h-6')</a>
            <a href="{{ route('trip.update.merge', $trip->id) }}" class="btn bg-white mr-2">@icon('git-merge', 'w-4 h-4 sm:w-6 sm:h-6')</a>
            <a href="{{ route('trip.export', $trip->id) }}" class="btn bg-white">@icon('package', 'w-4 h-4 sm:w-6 sm:h-6')</a>
        </div>
    </div>
</form>

<x-map :trip="$trip" :positions="$positions" data-map-show-last="true"></x-map>

@endif

@stop
