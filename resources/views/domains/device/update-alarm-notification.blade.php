@extends ('domains.device.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('device-update-alarm-update-alarm-notification.filter') }}" data-table-search="#alarm-notification-list-table" />

<div class="overflow-auto header-sticky">
    <table id="alarm-notification-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left w-1">{{ __('device-update-alarm-update-alarm-notification.alarm') }}</th>
                <th class="text-left w-1">{{ __('device-update-alarm-update-alarm-notification.name') }}</th>
                <th class="text-left">{{ __('device-update-alarm-update-alarm-notification.message') }}</th>
                <th class="text-left">{{ __('device-update-alarm-update-alarm-notification.config') }}</th>
                <th class="text-left">{{ __('device-update-alarm-update-alarm-notification.trip') }}</th>
                <th class="w-1">{{ __('device-update-alarm-update-alarm-notification.created_at') }}</th>
                <th class="w-1">{{ __('device-update-alarm-update-alarm-notification.telegram') }}</th>
                <th class="w-1">{{ __('device-update-alarm-update-alarm-notification.closed_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($notifications as $each)

            <tr>

                <td class="text-left w-1">
                    @if ($each->alarm)
                    <a href="{{ route('device.update.alarm.update', [$row->id, $each->alarm->id]) }}" class="block">{{ $each->typeFormat()->title() }}</a>
                    @else
                    {{ $each->typeFormat()->title() }}
                    @endif
                </td>
                <td class="text-left w-1"><span class="d-t-m-o max-w-2xs" title="{{ $each->name }}">{{ $each->name }}</span></td>
                <td class="text-left"><span class="d-t-m-o max-w-2xs" title="{{ $each->typeFormat()->message() }}">{{ $each->typeFormat()->message() }}</span></td>
                <td class="text-left"><span class="d-t-m-o max-w-2xs" title="@arrayAsText($each->typeFormat()->config())">@arrayAsBadges($each->typeFormat()->config())</span></td>
                <td class="text-left">
                    @if ($each->trip)
                    <a href="{{ route('trip.update.alarm-notification', $each->trip->id) }}#position-id-{{ $each->position?->id }}" title="{{ $each->trip->name }}" class="d-t-m-o max-w-2xs">{{ $each->trip->name }}</a>
                    @endif
                </td>
                <td class="w-1"><div class="d-t-m-o max-w-xs">@dateWithTimezone($each->created_at, $row->timezone->zone)</div></td>
                <td class="w-1">@status($each->telegram)</td>
                <td class="w-1">
                    @if ($each->closed_at)
                    @status(true)
                    @else
                    <a href="{{ route('alarm-notification.update.closed-at', $each->id) }}" class="block">@status(false)</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
