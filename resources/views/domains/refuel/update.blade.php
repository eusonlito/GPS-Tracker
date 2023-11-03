@extends ('domains.refuel.update-layout')

@section ('content')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <x-select name="user_id" :options="$users" value="id" text="name" id="refuel-update-user" :label="__('refuel-update.user')" readonly disabled></x-select>
    </div>
</div>

@endif

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.refuel.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('refuel-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('refuel-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal')

@stop
