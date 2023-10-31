@extends ('layouts.in')

@section ('body')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <form method="get">
            <x-select name="user_id" :options="$users" value="id" text="name" id="vehicle-create-user" :label="__('vehicle-create.user')" :selected="$REQUEST->input('user_id')" data-change-submit required></x-select>
        </form>
    </div>
</div>

@endif

<form method="post">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="user_id" value="{{ $user->id }}" />

    @include ('domains.vehicle.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('vehicle-create.save') }}</button>
        </div>
    </div>
</form>

@stop
