@extends ('domains.trip.update-layout')

@section ('content')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <x-select name="user_id" :options="$users" value="id" text="name" id="trip-update-user" :label="__('trip-update.user')" readonly disabled></x-select>
    </div>
</div>

@endif

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="trip-code" class="form-label">{{ __('trip-update.code') }}</label>

            <div class="input-group">
                <input type="text" name="code" class="form-control form-control-lg" id="trip-code" value="{{ $REQUEST->input('code') }}" readonly required>
                <button type="button" class="input-group-text input-group-text-lg" title="{{ __('common.generate') }}" data-password-generate="#trip-code" data-password-generate-format="uuid" tabindex="-1">@icon('refresh-cw', 'w-5 h-5')</button>
            </div>
        </div>

        <div class="p-2">
            <label for="trip-name" class="form-label">{{ __('trip-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="trip-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="shared" value="1" class="form-check-switch" id="trip-shared" {{ $REQUEST->input('shared') ? 'checked' : '' }}>
                <label for="trip-shared" class="form-check-label">{{ __('trip-update.shared') }}</label>
            </div>
        </div>

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="shared_public" value="1" class="form-check-switch" id="trip-shared_public" {{ $REQUEST->input('shared_public') ? 'checked' : '' }}>
                <label for="trip-shared_public" class="form-check-label">{{ __('trip-update.shared_public') }}</label>
            </div>
        </div>
    </div>

    @if ($row->shared)

    <div class="box p-5 mt-5">
        <div class="p-2">
            <span class="font-medium">{{ __('trip-update.shared-url') }}</span> <a href="{{ route('shared.trip', $row->code) }}" class="text-primary" target="_blank">{{ route('shared.trip', $row->code) }}</a>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('trip-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('trip-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal')

@stop
