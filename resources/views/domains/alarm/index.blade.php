@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('alarm-index.filter') }}" data-table-search="#alarm-list-table" />
        </div>

        <button type="button" class="sm:ml-4 mt-2 sm:mt-0 bg-white btn form-control-lg" data-notification-request data-notification-request-granted="{{ __('alarm-index.notifications-granted') }}" data-notification-request-denied="{{ __('alarm-index.notifications-denied') }}">{{ __('alarm-index.notifications-enable') }}</button>
    </div>
</form>

<div class="overflow-auto header-sticky">
    <table id="alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($devices_multiple)
                <th class="w-1">{{ __('alarm-index.device') }}</th>
                @endif

                <th class="w-1">{{ __('alarm-index.type') }}</th>
                <th class="text-left w-1">{{ __('alarm-index.name') }}</th>
                <th class="text-left">{{ __('alarm-index.config') }}</th>
                <th class="w-1">{{ __('alarm-index.created_at') }}</th>
                <th class="w-1">{{ __('alarm-index.telegram') }}</th>
                <th class="w-1">{{ __('alarm-index.enabled') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($route = route('device.update.alarm.update', [$row->device->id, $row->id]))

            <tr>
                @if ($devices_multiple)
                <td class="w-1"><a href="{{ route('device.update', $row->device->id) }}" class="block">{{ $row->device->name }}</a></td>
                @endif

                <td class="w-1"><a href="{{ $route }}" class="block">{{ $row->typeFormat()->title() }}</a></td>
                <td class="text-left w-1"><a href="{{ $route }}" class="block">{{ $row->name }}</a></td>
                <td class="text-left"><a href="{{ $route }}" class="block whitespace-normal">@arrayAsBadges($row->typeFormat()->config())</a></td>
                <td class="w-1"><a href="{{ $route }}" class="block">@dateWithTimezone($row->created_at, $row->device->timezone->zone)</a></td>
                <td class="w-1"><a href="{{ route('device.update.alarm.update.boolean', [$row->device->id, $row->id, 'telegram']) }}" class="block" data-update-boolean="telegram">@status($row->telegram)</a></td>
                <td class="w-1"><a href="{{ route('device.update.alarm.update.boolean', [$row->device->id, $row->id, 'enabled']) }}" class="block" data-update-boolean="enabled">@status($row->enabled)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
