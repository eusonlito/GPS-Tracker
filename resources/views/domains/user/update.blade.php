@extends ('domains.user.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="user-name" class="form-label">{{ __('user-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="user-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="user-email" class="form-label">{{ __('user-update.email') }}</label>
            <input type="email" name="email" class="form-control form-control-lg" id="user-email" value="{{ $REQUEST->input('email') }}" required>
        </div>

        <div class="p-2">
            <label for="user-password" class="form-label">{{ __('user-update.password') }}</label>

            <div class="input-group">
                <input type="password" name="password" class="form-control form-control-lg" id="user-password" value="{{ $REQUEST->input('password') }}" autocomplete="off" />
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.show') }}" data-password-show="#user-password" tabindex="-1">@icon('eye', 'w-5 h-5')</button>
            </div>
        </div>

        <div class="p-2">
            <x-select name="language_id" :options="$languages" value="id" text="name" :label="__('user-update.language')" required></x-select>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="admin" value="1" class="form-check-switch" id="user-admin" {{ $REQUEST->input('admin') ? 'checked' : '' }}>
                <label for="user-admin" class="form-check-label">{{ __('user-update.admin') }}</label>
            </div>
        </div>

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="user-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
                <label for="user-enabled" class="form-check-label">{{ __('user-update.enabled') }}</label>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            @if ($can_be_deleted)
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('user-update.delete-button') }}</a>
            @endif

            <button type="submit" class="btn btn-primary" data-click-one>{{ __('user-update.save') }}</button>
        </div>
    </div>
</form>

@includeWhen ($can_be_deleted, 'molecules.delete-modal', [
    'title' => __('user-update.delete-title'),
    'message' => __('user-update.delete-message'),
])

@stop
