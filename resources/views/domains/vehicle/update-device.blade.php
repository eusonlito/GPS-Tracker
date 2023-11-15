@extends ('domains.vehicle.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('vehicle-update-device.filter') }}" data-table-search="#vehicle-update-device-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <form method="post">
        <table id="vehicle-update-device-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
            <thead>
                <tr>
                    <th class="text-left">{{ __('vehicle-update-device.name') }}</th>
                    <th class="text-left">{{ __('vehicle-update-device.model') }}</th>
                    <th class="text-left">{{ __('vehicle-update-device.vehicle') }}</th>
                    <th class="w-1">{{ __('vehicle-update-device.enabled') }}</th>
                    <th class="w-1"><input type="checkbox" data-checkall="#vehicle-update-device-list-table > tbody" /></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $each)

                @php ($link = route('device.update', $each->id))

                <tr>
                    <td class="text-left"><a href="{{ $link }}" class="block">{{ $each->name }}</a></td>
                    <td class="text-left"><a href="{{ $link }}" class="block">{{ $each->model }}</a></td>
                    <td class="text-left"><a href="{{ $link }}" class="block">{{ $each->vehicle->name ?? '-' }}</a></td>
                    <td class="w-1">@status($each->enabled)</td>
                    <td class="w-1"><input type="checkbox" name="related[]" value="{{ $each->id }}" {{ ($each->vehicle?->id === $row->id) ? 'checked' : '' }} /></td>
                </tr>

                @endforeach
            </tbody>
        </table>

        <div class="box p-5 mt-5">
            <div class="text-right">
                <button type="submit" name="_action" value="updateDevice" class="btn btn-primary">{{ __('vehicle-update-device.relate') }}</button>
            </div>
        </div>
    </form>
</div>

@stop
