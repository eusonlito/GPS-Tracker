<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="user-name" class="form-label">{{ __('user-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="user-name"
            value="{{ $REQUEST->input('name') }}" required>
    </div>

    <div class="p-2">
        <label for="user-email" class="form-label">{{ __('user-create.email') }}</label>
        <input type="email" name="email" class="form-control form-control-lg" id="user-email"
            value="{{ $REQUEST->input('email') }}" required>
    </div>

    <div class="p-2">
        <label for="user-password" class="form-label">{{ __('user-create.password') }}</label>

        <div class="input-group">
            <input type="password" name="password" class="form-control form-control-lg" id="user-password"
                value="{{ $REQUEST->input('password') }}" autocomplete="off" />
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}"
                data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="p-2">
        <label for="user-api_key" class="form-label">{{ __('user-create.api_key') }}</label>

        <div class="input-group">
            <input type="password" name="api_key" class="form-control form-control-lg" id="user-api_key"
                value="{{ $REQUEST->input('api_key') }}" autocomplete="off" />

            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}"
                data-password-show="#user-api_key" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.copy') }}"
                data-copy="#user-api_key" tabindex="-1">@icon('clipboard', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}"
                data-password-generate="#user-api_key" data-password-generate-format="uuid"
                tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
            <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.reset') }}"
                data-input-default="#user-api_key" data-tabindex="-1">@icon('skip-back', 'w-5 h-5')</button>
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <x-select name="language_id" :options="$languages" value="id" text="name"
                :label="__('user-create.language')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="timezone_id" :options="$timezones" value="id" text="zone"
                :label="__('user-create.timezone')" required></x-select>
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <x-select name="preferences[units][distance]" :options="$preferences_units_distance"
                :label="__('user-create.preferences-units-distance')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][volume]" :options="$preferences_units_volume"
                :label="__('user-create.preferences-units-volume')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][money]" :options="$preferences_units_money"
                :label="__('user-create.preferences-units-money')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][decimal]" :options="$preferences_units_decimal"
                :label="__('user-create.preferences-units-decimal')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][thousand]" :options="$preferences_units_thousand"
                :label="__('user-create.preferences-units-thousand')" required></x-select>
        </div>
    </div>
</div>

<div class="box p-5 mt-5">
    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="admin" value="1" class="form-check-switch" id="user-admin" {{ $REQUEST->input('admin') ? 'checked' : '' }}>
            <label for="user-admin" class="form-check-label">{{ __('user-create.admin') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="manager" value="1" class="form-check-switch" id="user-manager" {{ $REQUEST->input('manager') ? 'checked' : '' }}>
            <label for="user-manager" class="form-check-label">{{ __('user-create.manager') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="api_key_enabled" value="1" class="form-check-switch" id="user-api_key_enabled"
                {{ $REQUEST->input('api_key_enabled') ? 'checked' : '' }}>
            <label for="user-api_key_enabled" class="form-check-label">{{ __('user-create.api_key_enabled') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="user-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="user-enabled" class="form-check-label">{{ __('user-create.enabled') }}</label>
        </div>
    </div>
</div>

<!-- <div class="box p-5 mt-5">
    <h2 class="text-lg font-semibold mb-3">{{ __('user-create.permissions') }}</h2>

    @foreach ($permissions as $permission)
        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-switch" id="permission-{{ $permission->id }}" 
                    {{ in_array($permission->id, $userPermissions ?? []) ? 'checked' : '' }}>
                <label for="permission-{{ $permission->id }}" class="form-check-label">{{ __($permission->name) }}</label>
            </div>
        </div>
    @endforeach
</div> -->