@extends ('domains.profile.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-name" class="form-label">{{ __('profile-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="user-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="user-email" class="form-label">{{ __('profile-update.email') }}</label>
            <input type="email" name="email" class="form-control form-control-lg" id="user-email" value="{{ $REQUEST->input('email') }}" required>
        </div>

        <div class="p-2">
            <label for="user-password" class="form-label">{{ __('profile-update.password') }}</label>

            <div class="input-group">
                <input type="password" name="password" class="form-control form-control-lg" id="user-password">
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            </div>
        </div>

        <div class="p-2">
            <x-select name="language_id" :options="$languages" value="id" text="name" :label="__('profile-update.language')" required></x-select>
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

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-password_current" class="form-label">{{ __('profile-update.password_current') }}</label>
            <input type="password" name="password_current" class="form-control form-control-lg" id="user-password_current" required>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('profile-update.save') }}</button>
        </div>
    </div>
</form>

@stop
