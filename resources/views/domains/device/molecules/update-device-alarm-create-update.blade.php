<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="device-type" class="form-label">{{ __('device-update-device-alarm-create.type') }}</label>
        <input type="text" name="type" class="form-control form-control-lg" id="device-type" value="{{ $REQUEST->input('type') }}" required>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="device-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="device-enabled" class="form-check-label">{{ __('device-update-device-alarm-create.enabled') }}</label>
        </div>
    </div>
</div>
