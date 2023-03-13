<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="alarm-create-name" class="form-label">{{ __('alarm-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="alarm-create-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="flex">
        <div class="flex-1 p-2">
            <label for="alarm-create-schedule_start" class="form-label">{{ __('alarm-create.schedule_start') }}</label>
            <input type="text" name="schedule_start" class="form-control form-control-lg" id="alarm-create-schedule_start" value="{{ $REQUEST->input('schedule_start') }}" placeholder="{{ __('alarm-create.schedule_start-placeholder') }}">
        </div>

        <div class="flex-1 p-2">
            <label for="alarm-create-schedule_end" class="form-label">{{ __('alarm-create.schedule_end') }}</label>
            <input type="text" name="schedule_end" class="form-control form-control-lg" id="alarm-create-schedule_end" value="{{ $REQUEST->input('schedule_end') }}" placeholder="{{ __('alarm-create.schedule_end-placeholder') }}">
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="alarm-create-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="alarm-create-enabled" class="form-check-label">{{ __('alarm-create.enabled') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="telegram" value="1" class="form-check-switch" id="alarm-create-telegram" {{ $REQUEST->input('telegram') ? 'checked' : '' }}>
            <label for="alarm-create-telegram" class="form-check-label">{{ __('alarm-create.telegram') }}</label>
        </div>
    </div>
</div>

@include ('domains.alarm.types.'.$type.'.create')
