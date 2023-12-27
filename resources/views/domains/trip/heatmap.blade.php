@extends ('layouts.in')

@section ('body')

<form id="trip-heatmap-form" method="get">
    <div class="lg:flex lg:space-x-4">
        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        @if ($vehicles_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        @if ($devices_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="device_id" :options="$devices" value="id" text="name" placeholder="{{ __('trip-index.device') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-index.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-index.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
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

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="start_end" :options="$starts_ends" placeholder="{{ __('trip-index.start_end') }}" data-change-submit></x-select>
        </div>

        @endif
    </div>
</form>

@if ($grid)

<div class="map-heat mt-5" data-map-heat data-map-heat-form="#trip-heatmap-form" data-map-heat-grid="{{ json_encode($grid) }}" data-map-heat-bbox="{{ json_encode($bbox) }}"></div>

@endif

@stop
