<div class="box p-5 mt-5">
    @include ('domains.device-alarm.types.'.$type.'.create')

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="device-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="device-enabled" class="form-check-label">{{ __('device-update-device-alarm-create.enabled') }}</label>
        </div>
    </div>
</div>
