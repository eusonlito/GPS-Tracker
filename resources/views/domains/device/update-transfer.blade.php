@extends ('domains.device.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="updateTransfer" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <x-select name="user_id" :options="$users" value="id" text="name" id="device-update-transfer-user" :label="__('device-update-transfer.user')" required></x-select>
        </div>
    </div>

    @if ($trips)

    <div class="box p-5 mt-5">
        <div class="p-2">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" id="device-update-transfer-vehicle" :label="__('device-update-transfer.vehicle', ['count' => $trips])" required></x-select>
        </div>

        <div class="p-2">
            <x-select name="device_id" :options="$devices" value="id" text="name" id="device-update-transfer-device" :label="__('device-update-transfer.device', ['count' => $trips])" required></x-select>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-danger" data-click-one>{{ __('device-update-transfer.save') }}</button>
        </div>
    </div>
</form>

@stop
