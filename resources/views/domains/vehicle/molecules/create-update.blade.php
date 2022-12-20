<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="vehicle-name" class="form-label">{{ __('vehicle-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="vehicle-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="p-2">
        <label for="vehicle-plate" class="form-label">{{ __('vehicle-create.plate') }}</label>
        <input type="text" name="plate" class="form-control form-control-lg" id="vehicle-plate" value="{{ $REQUEST->input('plate') }}">
    </div>

    <div class="p-2">
        <x-select name="timezone_id" :options="$timezones" value="id" text="zone" id="vehicle-create-timezone" :label="__('vehicle-create.timezone')" required></x-select>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="timezone_auto" value="1" class="form-check-switch" id="vehicle-timezone_auto" {{ $REQUEST->input('timezone_auto') ? 'checked' : '' }}>
            <label for="vehicle-timezone_auto" class="form-check-label">{{ __('vehicle-create.timezone_auto') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="vehicle-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="vehicle-enabled" class="form-check-label">{{ __('vehicle-create.enabled') }}</label>
        </div>
    </div>
</div>
