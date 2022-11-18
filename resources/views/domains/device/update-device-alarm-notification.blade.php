@extends ('domains.device.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('device-update-device-alarm-update-device-alarm-notification.filter') }}" data-table-search="#device-alarm-notification-list-table" />

<div class="overflow-auto header-sticky">
    <table id="device-alarm-notification-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="w-1 text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.alarm') }}</th>
                <th class="w-1 text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.name') }}</th>
                <th class="w-1 text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.message') }}</th>
                <th class="text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.config') }}</th>
                <th class="w-1 text-left">{{ __('device-update-device-alarm-update-device-alarm-notification.trip') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm-update-device-alarm-notification.created_at') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm-update-device-alarm-notification.closed_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($notifications as $each)

            <tr>
                <td class="text-left w-1"><a href="{{ route('device.update.device-alarm.update', [$row->id, $each->alarm->id]) }}" class="block">{{ $each->typeFormat()->title() }}</a></td>
                <td class="text-left w-1">{{ $each->name }}</td>
                <td class="text-left w-1"><span class="block truncate max-w-xs" title="{{ $each->typeFormat()->message() }}">{{ $each->typeFormat()->message() }}</span></td>
                <td class="text-left">@arrayAsBadges($each->typeFormat()->config())</td>
                <td class="text-left w-1">
                    @if ($each->trip)
                    <a href="{{ route('trip.update.map', $each->trip->id) }}#position-id-{{ $each->position?->id }}" title="{{ $each->trip->name }}" class="block truncate max-w-2xs">{{ $each->trip->name }}</a>
                    @endif
                </td>
                <td class="w-1">@dateWithTimezone($each->created_at, $row->timezone->zone)</td>
                <td class="w-1">
                    @if ($each->closed_at)
                    @status(true)
                    @else
                    <a href="{{ route('device-alarm-notification.update.closed-at', $each->id) }}" class="block">@status(false)</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
