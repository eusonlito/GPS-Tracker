@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('device-index.filter') }}" data-table-search="#device-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('device.create') }}" class="btn form-control-lg">{{ __('device-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="device-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th>{{ __('device-index.name') }}</th>
                <th>{{ __('device-index.maker') }}</th>
                <th>{{ __('device-index.port') }}</th>
                <th>{{ __('device-index.timezone') }}</th>
                <th>{{ __('device-index.connected_at') }}</th>
                <th>{{ __('device-index.enabled') }}</th>
                <th>{{ __('trip-index.alarms') }}</th>
                <th>{{ __('trip-index.notifications') }}</th>
                <th>{{ __('trip-index.messages') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('device.update', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->maker }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->port }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->timezone->zone }}</a></td>
                <td><a href="{{ $link }}" class="block">@dateWithTimezone($row->connected_at, $row->timezone->zone, 'Y-m-d H:i:s')</a></td>
                <td data-table-sort-value="{{ (int)$row->enabled }}" class="w-1">@status($row->enabled)</td>
                <td class="w-1"><a href="{{ route('device.update.alarm', $row->id) }}">{{ $row->alarms_count }}</a></td>
                <td class="w-1">
                    <a href="{{ route('device.update.alarm-notification', $row->id) }}" class="{{ $row->alarms_notifications_pending_count ? 'text-warning' : 'text-success' }}">
                        {{ $row->alarms_notifications_count.($row->alarms_notifications_pending_count ? ('/'.$row->alarms_notifications_pending_count) : '') }}
                    </a>
                </td>
                <td class="w-1">
                    <a href="{{ route('device.update.device-message', $row->id) }}" class="{{ $row->messages_pending_count ? 'text-warning' : 'text-success' }}">
                        {{ $row->messages_count.($row->messages_pending_count ? ('/'.$row->messages_pending_count) : '') }}
                    </a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
