@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="box p-5 mt-5">
        @if ($users_multiple)

        <div class="p-2">
            <x-select name="user_id" :options="$users" value="id" text="name" id="alarm-create-user" :label="__('alarm-create.user')" data-change-submit required></x-select>
        </div>

        @endif

        <div class="p-2">
            <x-select name="type" id="alarm-create-type" :options="$types" :label="__('alarm-create.type')" :placeholder="__('alarm-create.type-select')" data-change-submit required></x-select>
        </div>
    </div>
</form>

@if ($type)

<form method="post">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="type" value="{{ $type }}" />
    <input type="hidden" name="user_id" value="{{ $user->id }}" />

    @include ('domains.alarm.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('alarm-create.save') }}</button>
        </div>
    </div>
</form>

@endif

@stop
