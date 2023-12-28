@extends ('domains.country.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="country-code" class="form-label">{{ __('country-update.code') }}</label>
            <input name="code" class="form-control form-control-lg" id="country-code" value="{{ $REQUEST->input('code') }}" required>
        </div>

        <div class="p-2">
            <label for="country-name" class="form-label">{{ __('country-update.name') }}</label>
            <input name="name" class="form-control form-control-lg" id="country-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="country-alias" class="form-label">{{ __('country-update.alias') }}</label>
            <input name="alias" class="form-control form-control-lg" id="country-alias" value="{{ $REQUEST->input('alias') }}">
            <div class="form-help">{{ __('country-update.alias-comment') }}</div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('country-update.save') }}</button>
        </div>
    </div>
</form>

@stop
