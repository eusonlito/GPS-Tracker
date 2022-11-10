@extends ('domains.device.update-layout')

@section ('content')

<form method="get" class="mt-4">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('device-update-device-alarm.filter') }}" data-table-search="#device-alarm-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('device.update.device-alarm.create', $row->id) }}" class="btn form-control-lg">{{ __('device-update-device-alarm.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto header-sticky">
    <table id="device-alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="w-1">{{ __('device-update-device-alarm.type') }}</th>
                <th class="text-left">{{ __('device-update-device-alarm.config') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm.created_at') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm.enabled') }}</th>
                <th class="w-1">{{ __('device-update-device-alarm.notifications') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($alarms as $each)

            @php ($route = route('device.update.device-alarm.update', [$row->id, $each->id]))

            <tr>
                <td class="w-1"><a href="{{ $route }}" class="block">{{ $each->type }}</a></td>
                <td class="text-left"><a href="{{ $route }}" class="block whitespace-normal">@json($each->config)</a></td>
                <td><a href="{{ $route }}" class="block">@dateWithTimezone($row->created_at, $row->timezone->zone)</a></td>
                <td><a href="{{ $route }}" class="block">@status($row->enabled)</a></td>
                <td><a href="{{ $route }}" class="block">{{ $each->notifications_count }}</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
