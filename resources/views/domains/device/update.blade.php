@extends ('domains.device.update-layout')

@section ('content')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <x-select name="user_id" :options="$users" value="id" text="name" id="device-update-user" :label="__('device-update.user')" readonly disabled></x-select>
    </div>
</div>

@endif

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.device.molecules.create-update')

    @if ($row->shared)

    <div class="box p-5 mt-5">
        <div class="p-2">
            <span class="font-medium">{{ __('device-update.shared-url') }}</span> <a href="{{ route('shared.device', $row->code) }}" class="text-primary" target="_blank">{{ route('shared.device', $row->code) }}</a>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('device-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('device-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal', [
    'title' => __('device-update.delete-title'),
    'message' => __('device-update.delete-message'),
])

@stop
