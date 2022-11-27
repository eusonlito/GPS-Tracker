@extends ('domains.device.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('device-update-alarm.filter') }}" data-table-search="#alarm-list-table" />

<div class="overflow-auto lg:overflow-visible header-sticky">
    <form method="post">
        <table id="alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
            <thead>
                <tr>
                    <th class="w-1">{{ __('device-update-alarm.type') }}</th>
                    <th class="text-left w-1">{{ __('device-update-alarm.name') }}</th>
                    <th class="text-left">{{ __('device-update-alarm.config') }}</th>
                    <th class="w-1">{{ __('device-update-alarm.created_at') }}</th>
                    <th class="w-1">{{ __('device-update-alarm.telegram') }}</th>
                    <th class="w-1">{{ __('device-update-alarm.enabled') }}</th>
                    <th class="w-1"><input type="checkbox" data-checkall="#alarm-list-table > tbody" /></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($alarms as $each)

                @php ($route = route('alarm.update', $each->id))

                <tr>
                    <td class="w-1"><a href="{{ $route }}" class="block">{{ $each->typeFormat()->title() }}</a></td>
                    <td class="text-left w-1"><a href="{{ $route }}" class="block">{{ $each->name }}</a></td>
                    <td class="text-left"><span class="block whitespace-normal">@arrayAsBadges($each->typeFormat()->config())</span></td>
                    <td class="w-1">@dateWithTimezone($each->created_at)</td>
                    <td class="w-1">@status($each->telegram)</td>
                    <td class="w-1">@status($each->enabled)</td>
                    <td class="w-1"><input type="checkbox" name="related[]" value="{{ $each->id }}" {{ $each->devicePivot ? 'checked' : '' }} /></td>
                </tr>

                @endforeach
            </tbody>
        </table>

        <div class="box p-5 mt-5">
            <div class="text-right">
                <button type="submit" name="_action" value="updateAlarm" class="btn btn-primary">{{ __('device-update-alarm.relate') }}</button>
            </div>
        </div>
    </form>
</div>

@stop
