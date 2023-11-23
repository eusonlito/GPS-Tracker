@extends ('domains.vehicle.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('vehicle-update-alarm.filter') }}" data-table-search="#alarm-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <form method="post">
        <table id="alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
            <thead>
                <tr>
                    <th class="w-1">{{ __('vehicle-update-alarm.type') }}</th>
                    <th class="text-left w-1">{{ __('vehicle-update-alarm.name') }}</th>
                    <th class="w-1">{{ __('vehicle-update-alarm.created_at') }}</th>
                    <th class="w-1">{{ __('vehicle-update-alarm.telegram') }}</th>
                    <th class="w-1">{{ __('vehicle-update-alarm.enabled') }}</th>
                    <th class="w-1"><input type="checkbox" data-checkall="#alarm-list-table > tbody" /></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($alarms as $each)

                @php ($link = route('alarm.update', $each->id))

                <tr>
                    <td class="w-1"><a href="{{ $link }}" class="block">{{ $each->typeFormat()->title() }}</a></td>
                    <td class="text-left w-1"><a href="{{ $link }}" class="block">{{ $each->name }}</a></td>
                    <td class="w-1" data-table-sort-value="{{ $each->created_at }}">@dateWithUserTimezone($each->created_at)</td>
                    <td class="w-1">@status($each->telegram)</td>
                    <td class="w-1">@status($each->enabled)</td>
                    <td class="w-1"><input type="checkbox" name="related[]" value="{{ $each->id }}" {{ $each->vehiclePivot ? 'checked' : '' }} /></td>
                </tr>

                @endforeach
            </tbody>
        </table>

        <div class="box p-5 mt-5">
            <div class="text-right">
                <button type="submit" name="_action" value="updateAlarm" class="btn btn-primary">{{ __('vehicle-update-alarm.relate') }}</button>
            </div>
        </div>
    </form>
</div>

@stop
