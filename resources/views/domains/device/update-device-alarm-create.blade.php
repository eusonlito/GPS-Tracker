@extends ('domains.device.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="updateDeviceAlarmCreate" />

    @include ('domains.device.molecules.update-device-alarm-create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('device-update-device-alarm-create.save') }}</button>
        </div>
    </div>
</form>

@stop
