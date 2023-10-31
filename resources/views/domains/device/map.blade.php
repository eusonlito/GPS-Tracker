@extends ('layouts.in')

@section ('body')

<form method="get" class="mb-5">
    <div class="lg:flex lg:space-x-4">
        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('device-map-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('device-map-index.vehicle') }}" data-change-submit></x-select>
        </div>
    </div>
</form>

<x-map-device :devices="$list"></x-map-device>

@stop
