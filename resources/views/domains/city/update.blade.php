@extends ('domains.city.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="city-name" class="form-label">{{ __('city-update.name') }}</label>
            <input name="name" class="form-control form-control-lg" id="city-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="city-alias" class="form-label">{{ __('city-update.alias') }}</label>
            <input name="alias" class="form-control form-control-lg" id="city-alias" value="{{ $REQUEST->input('alias') }}">
            <div class="form-help">{{ __('city-update.alias-comment') }}</div>
        </div>

        <div class="flex">
            <div class="flex-1 p-2">
                <x-select name="state_id" :options="$states" value="id" text="name" id="city-state_id" :label="__('city-update.state')" required></x-select>
            </div>

            <div class="flex-1 p-2">
                <x-select name="country_id" :options="$countries" value="id" text="name" id="city-country_id" :label="__('city-update.country')" required></x-select>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5 md:flex">
        <div class="flex-1 p-2">
            <label for="city-update-latitude" class="form-label">{{ __('city-update.latitude') }}</label>
            <input type="number" name="latitude" class="form-control form-control-lg" id="city-update-latitude" value="{{ $REQUEST->input('latitude') }}" step="any" required>
        </div>

        <div class="flex-1 p-2">
            <label for="city-update-longitude" class="form-label">{{ __('city-update.longitude') }}</label>
            <input type="number" name="longitude" class="form-control form-control-lg" id="city-update-longitude" value="{{ $REQUEST->input('longitude') }}" step="any" required>
        </div>
    </div>

    <div class="map-point mt-5" data-map-point data-map-point-latitude="#city-update-latitude" data-map-point-longitude="#city-update-longitude"></div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('city-update.save') }}</button>
        </div>
    </div>
</form>

@stop
