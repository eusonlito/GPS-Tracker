@extends ('domains.device.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="updateDeviceMessageCreate" />

    <div class="box p-5 mt-5">
        <div class="flex">
            <div class="flex-1 p-2">
                <input type="text" name="message" class="form-control form-control-lg" id="device-message-message" placeholder="{{ __('device-update-device-message.message') }}" required>
            </div>

            <div class="p-2">
                <button type="submit" class="btn btn-primary form-control-lg">{{ __('device-update-device-message.send') }}</button>
            </div>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="device-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="text-center">{{ __('device-update-device-message.message') }}</th>
                <th class="text-center">{{ __('device-update-device-message.response') }}</th>
                <th class="text-center">{{ __('device-update-device-message.created_at') }}</th>
                <th class="text-center">{{ __('device-update-device-message.sent_at') }}</th>
                <th class="text-center">{{ __('device-update-device-message.response_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($messages as $each)

            <tr>
                <td><span class="block font-semibold whitespace-nowrap truncate max-w-xs" title="{{ $each->message }}">{{ $each->message }}</span></td>
                <td><span class="block font-semibold whitespace-nowrap truncate max-w-xs" title="{{ $each->response }}">{{ $each->response }}</span></td>
                <td><span class="block font-semibold whitespace-nowrap">@dateWithTimezone($each->created_at, $row->timezone->zone, 'Y-m-d H:i:s')</span></td>
                <td><span class="block font-semibold whitespace-nowrap">@dateWithTimezone($each->sent_at, $row->timezone->zone, 'Y-m-d H:i:s')</span></td>
                <td><span class="block font-semibold whitespace-nowrap">@dateWithTimezone($each->response_at, $row->timezone->zone, 'Y-m-d H:i:s')</span></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
