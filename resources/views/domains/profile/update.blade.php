@extends ('domains.profile.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="profile-update-name" class="form-label">{{ __('profile-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="profile-update-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="profile-update-email" class="form-label">{{ __('profile-update.email') }}</label>
            <input type="email" name="email" class="form-control form-control-lg" id="profile-update-email" value="{{ $REQUEST->input('email') }}" required>
        </div>

        <div class="p-2">
            <label for="profile-update-password" class="form-label">{{ __('profile-update.password') }}</label>

            <div class="input-group">
                <input type="password" name="password" class="form-control form-control-lg" id="profile-update-password">
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#profile-update-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            </div>
        </div>

        <div class="lg:flex">
            <div class="flex-1 p-2">
                <x-select name="language_id" :options="$languages" value="id" text="name" :label="__('profile-update.language')" required></x-select>
            </div>

            <div class="flex-1 p-2">
                <x-select name="timezone_id" :options="$timezones" value="id" text="zone" :label="__('profile-update.timezone')" required></x-select>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5 md:flex">
        <div class="flex-1 p-2">
            <x-select name="preferences[units][distance]" :options="$preferences_units_distance" :label="__('profile-update.preferences-units-distance')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][volume]" :options="$preferences_units_volume" :label="__('profile-update.preferences-units-volume')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][money]" :options="$preferences_units_money" :label="__('profile-update.preferences-units-money')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][decimal]" :options="$preferences_units_decimal" :label="__('profile-update.preferences-units-decimal')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="preferences[units][thousand]" :options="$preferences_units_thousand" :label="__('profile-update.preferences-units-thousand')" required></x-select>
        </div>
    </div>

    @if ($admin || $manager)

    <div class="box p-5 mt-5">
        @if ($manager)

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="manager_mode" value="1" class="form-check-switch" id="profile-update-manager_mode" {{ $REQUEST->input('manager_mode') ? 'checked' : '' }}>
                <label for="profile-update-manager_mode" class="form-check-label">{{ __('profile.manager_mode') }}</label>
            </div>
        </div>

        @endif

        @if ($admin)

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="admin_mode" value="1" class="form-check-switch" id="profile-update-admin_mode" {{ $REQUEST->input('admin_mode') ? 'checked' : '' }}>
                <label for="profile-update-admin_mode" class="form-check-label">{{ __('profile.admin_mode') }}</label>
            </div>
        </div>

        @endif
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="profile-update-password_current" class="form-label">{{ __('profile-update.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="profile-update-password_current" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('profile-update.save') }}</button>
        </div>
    </div>
</form>

@stop
