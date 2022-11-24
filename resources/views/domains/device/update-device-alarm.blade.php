@extends ('domains.device.update-layout')

@section ('content')

<form method="get" class="mt-5">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('device-update-device-alarm.filter') }}" data-table-search="#device-alarm-list-table" />
        </div>

        <button type="button" class="sm:ml-4 mt-2 sm:mt-0 bg-white btn form-control-lg" data-notification-request data-notification-request-granted="{{ __('device-update-device-alarm.notifications-granted') }}" data-notification-request-denied="{{ __('device-update-device-alarm.notifications-denied') }}">{{ __('device-update-device-alarm.notifications-enable') }}</button>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('device.update.device-alarm.create', $row->id) }}" class="btn form-control-lg">{{ __('device-update-device-alarm.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto header-sticky">
    <table id="device-alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="w-1">{{ __('device-update-device-alarm.type') }}</th>
                <th class="text-left w-1">{{ __('device-update-device-alarm.name') }}</th>
                <th class="text-left">{{ __('device-update-device-alarm.config') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm.created_at') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm.telegram') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm.enabled') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($alarms as $each)

            @php ($route = route('device.update.device-alarm.update', [$row->id, $each->id]))

            <tr>
                <td class="w-1"><a href="{{ $route }}" class="block">{{ $each->typeFormat()->title() }}</a></td>
                <td class="text-left w-1"><a href="{{ $route }}" class="block">{{ $each->name }}</a></td>
                <td class="text-left"><a href="{{ $route }}" class="block whitespace-normal">@arrayAsBadges($each->typeFormat()->config())</a></td>
                <td class="w-1"><a href="{{ $route }}" class="block">@dateWithTimezone($each->created_at, $row->timezone->zone)</a></td>
                <td class="w-1"><a href="{{ route('device.update.device-alarm.update.boolean', [$row->id, $each->id, 'telegram']) }}" class="block" data-update-boolean="telegram">@status($each->telegram)</a></td>
                <td class="w-1"><a href="{{ route('device.update.device-alarm.update.boolean', [$row->id, $each->id, 'enabled']) }}" class="block" data-update-boolean="enabled">@status($each->enabled)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
