@extends ('domains.alarm.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('alarm-update-vehicle.filter') }}" data-table-search="#vehicle-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <form method="post">
        <table id="vehicle-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
            <thead>
                <tr>
                    <th>{{ __('alarm-update-vehicle.name') }}</th>
                    <th>{{ __('alarm-update-vehicle.plate') }}</th>
                    <th>{{ __('alarm-update-vehicle.timezone') }}</th>
                    <th>{{ __('alarm-update-vehicle.enabled') }}</th>
                    <th class="w-1"><input type="checkbox" data-checkall="#vehicle-list-table > tbody" /></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($vehicles as $each)

                <tr>
                    <td><a href="{{ route('vehicle.update', $each->id) }}" class="block">{{ $each->name }}</a></td>
                    <td>{{ $each->plate }}</td>
                    <td>{{ $each->timezone->zone }}</td>
                    <td data-table-sort-value="{{ (int)$each->enabled }}" class="w-1">@status($each->enabled)</td>
                    <td class="w-1"><input type="checkbox" name="related[]" value="{{ $each->id }}" {{ $each->alarmPivot ? 'checked' : '' }} /></td>
                </tr>

                @endforeach
            </tbody>
        </table>

        <div class="box p-5 mt-5">
            <div class="text-right">
                <button type="submit" name="_action" value="updateVehicle" class="btn btn-primary">{{ __('alarm-update-vehicle.relate') }}</button>
            </div>
        </div>
    </form>
</div>

@stop
