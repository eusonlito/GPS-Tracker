<app-map class="map map-list-hidden" data-map-device data-map-devices="{{ $devicesJson }}" {{ $attributes }}>
    <div class="map-map {{ $sidebarHidden ? 'w-full' : '' }}" data-map-map>
        <div class="map-map-render" data-map-render></div>
    </div>

    @if ($sidebarHidden === false)

    <div class="map-list box px-5 py-2" data-map-list>
        <div class="flex items-center text-center">
            <a href="#" class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600 map-list-toggle" data-map-list-toggle>
                ⟻
            </a>
        </div>

        <table class="table table-report font-medium text-center whitespace-nowrap text-xs" data-map-list-table data-table-sort>
            <thead>
                <tr>
                    <th class="w-1">{{ __('map-device.name') }}</th>
                    <th class="w-1">{{ __('map-device.vehicle') }}</th>
                    <th class="w-1"><input type="checkbox" data-checkall="[data-map-list-table] > tbody" checked /></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $each)

                <tr>
                    <td class="w-1"><a href="#" data-map-point="{{ $each->positionLast->id }}">{{ $each->name }}</a></td>
                    <td class="w-1"><a href="#">{{ $each->vehicle->name ?? '-' }}</a></td>
                    <td class="w-1"><input type="checkbox" name="visible[]" value="{{ $each->positionLast->id }}" data-map-list-visible checked /></td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</app-map>
