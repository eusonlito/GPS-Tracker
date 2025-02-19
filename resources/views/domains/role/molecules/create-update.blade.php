<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="role-create-name" class="form-label">{{ __('role-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="role-create-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="flex">
        <div class="flex-1 p-2">
            <label for="role-create-schedule_start" class="form-label">{{ __('role-create.schedule_start') }}</label>
            <input type="text" name="schedule_start" class="form-control form-control-lg" id="role-create-schedule_start" value="{{ $REQUEST->input('schedule_start') }}" placeholder="{{ __('role-create.schedule_start-placeholder') }}">
        </div>

        <div class="flex-1 p-2">
            <label for="role-create-schedule_end" class="form-label">{{ __('role-create.schedule_end') }}</label>
            <input type="text" name="schedule_end" class="form-control form-control-lg" id="role-create-schedule_end" value="{{ $REQUEST->input('schedule_end') }}" placeholder="{{ __('role-create.schedule_end-placeholder') }}">
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="role-create-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="role-create-enabled" class="form-check-label">{{ __('role-create.enabled') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="telegram" value="1" class="form-check-switch" id="role-create-telegram" {{ $REQUEST->input('telegram') ? 'checked' : '' }}>
            <label for="role-create-telegram" class="form-check-label">{{ __('role-create.telegram') }}</label>
        </div>
    </div>
</div>

@include ('domains.role.types.'.$type.'.create')