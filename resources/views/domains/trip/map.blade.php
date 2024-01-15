@extends ('layouts.in')

@section ('body')

<form id="trip-map-form" class="mb-5" method="get">
    <div class="lg:flex lg:space-x-4">
        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('trip-map.user') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($vehicles_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('trip-map.vehicle') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($devices_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="device_id" :options="$devices" value="id" text="name" placeholder="{{ __('trip-map.device') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="finished" :options="$filter_finished" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-map.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-map.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="country_id" :options="$countries" value="id" text="name" placeholder="{{ __('trip-map.country') }}" data-change-submit></x-select>
        </div>

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="state_id" :options="$states" value="id" text="name" placeholder="{{ __('trip-map.state') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($state)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="city_id" :options="$cities" value="id" text="name" placeholder="{{ __('trip-map.city') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="start_end" :options="$starts_ends" placeholder="{{ __('trip-map.start_end') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <button type="submit" name="_action" value="show" class="btn bg-white form-control-lg whitespace-nowrap">{{ __('trip-map.send') }}</button>
        </div>
    </div>
</form>

<x-map-trip data-map-trip-form="#trip-map-form" user-show="{{ $user_show }}" vehicle-show="{{ $vehicle_show }}" device-show="{{ $device_show }}"></x-map-trip>

@stop
