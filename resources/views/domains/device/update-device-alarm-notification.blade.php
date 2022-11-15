@extends ('domains.device.update-layout')

@section ('content')

<div class="overflow-auto header-sticky">
    <table id="device-alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="w-1">{{ __('device-update-device-alarm-update-device-alarm-notification.alarm') }}</th>
                <th class="text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.message') }}</th>
                <th class="text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.config') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm-update-device-alarm-notification.created_at') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm-update-device-alarm-notification.closed_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($notifications as $each)

            <tr>
                <td class="w-1"><a href="{{ route('device.update.device-alarm.update', [$row->id, $each->alarm->id]) }}" class="block whitespace-normal">{{ $each->typeFormat()->title() }}</a></td>
                <td class="text-left"><span class="block whitespace-normal">@include ('domains.device-alarm.types.'.$each->type.'.notification', ['row' => $each->alarm, 'notification' => $each])</span></td>
                <td class="text-left"><span class="block whitespace-normal">@include ('domains.device-alarm.types.'.$each->type.'.config-values', ['config' => $each->config])</span></td>
                <td><span class="block">@dateWithTimezone($each->created_at, $row->timezone->zone)</span></td>
                <td>
                    @if ($each->closed_at)
                    <span class="block">@status(true)</span>
                    @else
                    <a href="{{ route('device.update.device-alarm-notification.update.closed-at', [$row->id, $each->id]) }}" class="block">@status(false)</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
