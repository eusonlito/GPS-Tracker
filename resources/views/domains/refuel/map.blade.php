@extends ('layouts.in')

@section ('body')

<form method="get" class="mb-5">
    <div class="lg:flex lg:space-x-4">
        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('refuel-map-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('refuel-map-index.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="country_id" :options="$countries" value="id" text="name" placeholder="{{ __('trip-index.country') }}" data-change-submit></x-select>
        </div>

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="state_id" :options="$states" value="id" text="name" placeholder="{{ __('trip-index.state') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($state)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="city_id" :options="$cities" value="id" text="name" placeholder="{{ __('trip-index.city') }}" data-change-submit></x-select>
        </div>

        @endif
    </div>
</form>

<x-map-refuel :refuels="$list"></x-map-refuel>

@stop
