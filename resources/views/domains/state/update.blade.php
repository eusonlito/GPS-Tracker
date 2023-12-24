@extends ('domains.state.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="state-name" class="form-label">{{ __('state-update.name') }}</label>
            <input name="name" class="form-control form-control-lg" id="state-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <label for="state-alias" class="form-label">{{ __('state-update.alias') }}</label>
            <input name="alias" class="form-control form-control-lg" id="state-alias" value="{{ $REQUEST->input('alias') }}">
            <div class="form-help">{{ __('state-update.alias-comment') }}</div>
        </div>

        <div class="p-2">
            <x-select name="country_id" :options="$countries" value="id" text="name" id="state-country_id" :label="__('state-update.country')" required></x-select>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('state-update.save') }}</button>
        </div>
    </div>
</form>

@stop
