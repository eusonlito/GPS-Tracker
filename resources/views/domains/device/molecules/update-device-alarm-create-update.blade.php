<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="device-update-alarm-create-name" class="form-label">{{ __('device-update-alarm-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="device-update-alarm-create-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="device-update-alarm-create-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="device-update-alarm-create-enabled" class="form-check-label">{{ __('device-update-alarm-create.enabled') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="telegram" value="1" class="form-check-switch" id="device-update-alarm-create-telegram" {{ $REQUEST->input('telegram') ? 'checked' : '' }}>
            <label for="device-update-alarm-create-telegram" class="form-check-label">{{ __('device-update-alarm-create.telegram') }}</label>
        </div>
    </div>
</div>

@include ('domains.alarm.types.'.$type.'.create')
