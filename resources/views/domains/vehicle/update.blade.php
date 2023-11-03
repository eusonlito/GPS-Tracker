@extends ('domains.vehicle.update-layout')

@section ('content')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <x-select name="user_id" :options="$users" value="id" text="name" id="vehicle-update-user" :label="__('vehicle-update.user')" readonly disabled></x-select>
    </div>
</div>

@endif

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.vehicle.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('vehicle-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('vehicle-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal', [
    'title' => __('vehicle-update.delete-title'),
    'message' => __('vehicle-update.delete-message'),
])

@stop
