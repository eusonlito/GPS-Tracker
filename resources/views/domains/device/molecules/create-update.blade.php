<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="device-code" class="form-label">{{ __('device-update.code') }}</label>

        <div class="input-group">
            <input type="text" name="code" class="form-control form-control-lg" id="device-code" value="{{ $REQUEST->input('code') }}" readonly required>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}" data-password-generate="#device-code" data-password-generate-format="uuid" tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="p-2">
        <label for="device-name" class="form-label">{{ __('device-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="device-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="p-2">
        <label for="device-model" class="form-label">{{ __('device-create.model') }}</label>
        <input type="text" name="model" class="form-control form-control-lg" id="device-model" value="{{ $REQUEST->input('model') }}" required>
    </div>

    <div class="p-2">
        <label for="device-serial" class="form-label">{{ __('device-create.serial') }}</label>
        <input type="text" name="serial" class="form-control form-control-lg" id="device-serial" value="{{ $REQUEST->input('serial') }}" required>
    </div>

    <div class="p-2">
        <label for="device-phone_number" class="form-label">{{ __('device-create.phone_number') }}</label>
        <input type="text" name="phone_number" class="form-control form-control-lg" id="device-phone_number" value="{{ $REQUEST->input('phone_number') }}">
    </div>

    <div class="flex-1 p-2">
        <label for="device-password" class="form-label">{{ __('device-create.password') }}</label>

        <div class="input-group">
            <input type="password" name="password" class="form-control form-control-lg" id="device-password" value="{{ $REQUEST->input('password') }}" step="1" />
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#device-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="p-2">
        <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" id="device-create-vehicle" :label="__('device-create.vehicle')" :placeholder="__('device-create.vehicle-select')"></x-select>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="device-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="device-enabled" class="form-check-label">{{ __('device-create.enabled') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="shared" value="1" class="form-check-switch" id="device-shared" {{ $REQUEST->input('shared') ? 'checked' : '' }}>
            <label for="device-shared" class="form-check-label">{{ __('device-create.shared') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="shared_public" value="1" class="form-check-switch" id="device-shared_public" {{ $REQUEST->input('shared_public') ? 'checked' : '' }}>
            <label for="device-shared_public" class="form-check-label">{{ __('device-create.shared_public') }}</label>
        </div>
    </div>
</div>
