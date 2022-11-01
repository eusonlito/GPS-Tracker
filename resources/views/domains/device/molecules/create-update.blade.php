<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="device-name" class="form-label">{{ __('device-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="device-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="p-2">
        <label for="device-maker" class="form-label">{{ __('device-create.maker') }}</label>
        <input type="text" name="maker" class="form-control form-control-lg" id="device-maker" value="{{ $REQUEST->input('maker') }}" required>
    </div>

    <div class="p-2">
        <label for="device-serial" class="form-label">{{ __('device-create.serial') }}</label>
        <input type="text" name="serial" class="form-control form-control-lg" id="device-serial" value="{{ $REQUEST->input('serial') }}" required>
    </div>

    <div class="flex-1 p-2">
        <label for="device-password" class="form-label">{{ __('device-create.password') }}</label>

        <div class="input-group">
            <input type="password" name="password" class="form-control form-control-lg" id="device-password" value="{{ $REQUEST->input('password') }}" step="1" />
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#device-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="p-2">
        <label for="device-port" class="form-label">{{ __('device-create.port') }}</label>
        <input type="number" name="port" class="form-control form-control-lg" id="device-port" value="{{ $REQUEST->input('port') }}" min="0" step="1">
    </div>

    <div class="p-2">
        <x-select name="timezone_id" :options="$timezones" value="id" text="zone" id="device-create-timezone" :label="__('device-create.timezone')" required></x-select>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="timezone_auto" value="1" class="form-check-switch" id="device-timezone_auto" {{ $REQUEST->input('timezone_auto') ? 'checked' : '' }}>
            <label for="device-timezone_auto" class="form-check-label">{{ __('device-create.timezone_auto') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="device-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="device-enabled" class="form-check-label">{{ __('device-create.enabled') }}</label>
        </div>
    </div>
</div>
