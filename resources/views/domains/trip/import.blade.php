@extends ('layouts.in')

@section ('body')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <form method="get">
            <x-select name="user_id" :options="$users" value="id" text="name" id="trip-import-user" :label="__('trip-import.user')" :selected="$REQUEST->input('user_id')" data-change-submit required></x-select>
        </form>
    </div>
</div>

@endif

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="import" />
    <input type="hidden" name="user_id" value="{{ $user->id }}" />

    <div class="box p-5 mt-5">
        <div class="lg:flex">
            <div class="flex-1 p-2">
                <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" id="trip-import-vehicle" :label="__('trip-import.vehicle')"></x-select>
            </div>

            <div class="flex-1 p-2">
                <x-select name="device_id" :options="$devices" value="id" text="name" id="trip-import-device" :label="__('trip-import.device')"></x-select>
            </div>

            <div class="flex-1 p-2">
                <x-select name="timezone_id" :options="$timezones" value="id" text="zone" :label="__('user-create.timezone')" required></x-select>
            </div>
        </div>

        <div class="p-2">
            <label for="trip-import-file" class="form-label block truncate">{{ __('trip-import.file') }}</label>

            <div class="input-group input-file-custom" data-input-file-custom>
                <input type="text" class="form-control form-control-lg truncate" readonly />
                <label for="trip-import-file" class="input-group-text input-group-text-lg border-0">@icon('upload', 'w-5 h-5')</label>
                <input type="file" name="file" id="trip-import-file" class="hidden" accept=".gpx" />
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('trip-import.save') }}</button>
        </div>
    </div>
</form>

@stop
