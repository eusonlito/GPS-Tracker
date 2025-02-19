@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="box p-5 mt-5">
        @if ($users_multiple)

        <div class="p-2">
            <x-select name="user_id" :options="$users" value="id" text="name" id="role-create-user" :label="__('role-create.user')" data-change-submit required></x-select>
        </div>

        @endif

        <div class="p-2">
            <x-select name="type" id="role-create-type" :options="$types" :label="__('role-create.type')" :placeholder="__('role-create.type-select')" data-change-submit required></x-select>
        </div>
    </div>
</form>

@if ($type)

<form method="post">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="type" value="{{ $type }}" />
    <input type="hidden" name="user_id" value="{{ $user->id }}" />

    @include ('domains.role.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('role-create.save') }}</button>
        </div>
    </div>
</form>

@endif

@stop