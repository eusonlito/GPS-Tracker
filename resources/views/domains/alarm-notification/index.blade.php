@extends ('layouts.in')

@section ('body')

<input type="search" class="form-control form-control-lg" placeholder="{{ __('alarm-notification-index.filter') }}" data-table-search="#alarm-notification-list-table" />

<div class="overflow-auto header-sticky">
    <table id="alarm-notification-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($devices_multiple)
                <th class="w-1">{{ __('alarm-notification-index.device') }}</th>
                @endif

                <th class="text-left w-1">{{ __('alarm-notification-index.alarm') }}</th>
                <th class="text-left w-1">{{ __('alarm-notification-index.name') }}</th>
                <th class="text-left">{{ __('alarm-notification-index.message') }}</th>
                <th class="text-left">{{ __('alarm-notification-index.config') }}</th>
                <th class="text-left">{{ __('alarm-notification-index.trip') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.created_at') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.telegram') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.closed_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                @if ($devices_multiple)
                <td class="w-1"><a href="{{ route('device.update', $row->device->id) }}" class="block">{{ $row->device->name }}</a></td>
                @endif

                <td class="text-left w-1">
                    @if ($row->alarm)
                    <a href="{{ route('alarm.update', $row->alarm->id) }}" class="block">{{ $row->typeFormat()->title() }}</a>
                    @else
                    {{ $row->typeFormat()->title() }}
                    @endif
                </td>
                <td class="text-left w-1"><span class="d-t-m-o max-w-2xs" title="{{ $row->name }}">{{ $row->name }}</span></td>
                <td class="text-left"><span class="d-t-m-o max-w-2xs" title="{{ $row->typeFormat()->message() }}">{{ $row->typeFormat()->message() }}</span></td>
                <td class="text-left"><span class="d-t-m-o max-w-2xs" title="@arrayAsText($row->typeFormat()->config())">@arrayAsBadges($row->typeFormat()->config())</span></td>
                <td class="text-left">
                    @if ($row->trip)
                    <a href="{{ route('trip.update.alarm-notification', $row->trip->id) }}#position-id-{{ $row->position?->id }}" title="{{ $row->trip->name }}" class="d-t-m-o max-w-2xs">{{ $row->trip->name }}</a>
                    @endif
                </td>
                <td class="w-1"><div class="d-t-m-o max-w-xs">@dateWithTimezone($row->created_at, $row->device->timezone->zone)</div></td>
                <td class="w-1">@status($row->telegram)</td>
                <td class="w-1">
                    @if ($row->closed_at)
                    @status(true)
                    @else
                    <a href="{{ route('alarm-notification.update.closed-at', $row->id) }}" class="block">@status(false)</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
