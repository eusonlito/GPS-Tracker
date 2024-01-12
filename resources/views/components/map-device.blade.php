<app-map class="map map-list-hidden" data-map-device data-map-device-list="{{ $devicesJson }}" {{ $attributes }}>
    <div class="map-map {{ $sidebarHidden ? 'w-full' : '' }}" data-map-map>
        <div class="map-map-render" data-map-render data-map-control-markers-disabled></div>
    </div>

    @if ($sidebarHidden === false)

    <div class="map-list box px-5 py-2" data-map-list>
        <div class="flex items-center text-center">
            <a href="#" class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600 map-list-toggle" data-map-list-toggle>
                ⟻
            </a>
        </div>

        <form method="get">
            <div class="p-2">
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('device-map.filter') }}" data-table-search="#map-device-list-table-{{ $id }}" />
            </div>

            <div class="flex">
                <div class="p-2">
                    <a href="#" class="btn bg-white mr-2" data-map-live>@icon('play', 'w-6 h-6')</a>
                </div>

                <div class="flex-1 p-2">
                    <x-select name="finished" :options="$filterFinished" data-map-trip-finished="{{ $filterFinishedMinutes }}"></x-select>
                </div>
            </div>
        </form>

        <table id="map-device-list-table-{{ $id }}" class="table table-report font-medium text-center whitespace-nowrap text-xs" data-map-list-table data-table-sort>
            <thead>
                <tr>
                    <th class="w-1"><input type="checkbox" data-checkall="#map-device-list-table-{{ $id }} > tbody" checked /></th>
                    <th class="w-1">{{ __('map-device.name') }}</th>
                    <th class="w-1">{{ __('map-device.vehicle') }}</th>
                    <th class="w-1">{{ __('map-device.plate') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $each)

                <tr>
                    <td class="w-1"><input type="checkbox" name="visible[]" value="{{ $each->id }}" data-map-list-visible checked /></td>
                    <td class="w-1"><a href="#" data-map-point="{{ $each->id }}">{{ $each->name }}</a></td>
                    <td class="w-1"><a href="#" data-map-point="{{ $each->id }}">{{ $each->vehicle->name ?? '-' }}</a></td>
                    <td class="w-1"><a href="#" data-map-point="{{ $each->id }}">{{ $each->vehicle->plate ?? '-' }}</a></td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</app-map>
