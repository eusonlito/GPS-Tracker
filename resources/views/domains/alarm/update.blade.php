@extends ('domains.alarm.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <x-select name="type" id="alarm-update-type" :options="$types" :label="__('alarm-update.type')" readonly disabled></x-select>
        </div>
    </div>

    @if ($users_multiple)

    <div class="box p-5 mt-5">
        <div class="p-2">
            <x-select name="user_id" :options="$users" value="id" text="name" id="alarm-update-user" :label="__('alarm-update.user')" readonly disabled></x-select>
        </div>
    </div>

    @endif

    @include ('domains.alarm.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('alarm-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('alarm-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal', [
    'action' => 'delete'
])

@stop
