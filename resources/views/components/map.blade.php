<app-map class="map map-list-hidden" data-map data-map-id="{{ $trip->id }}" data-map-positions="{{ $positionsJson }}" data-map-alarms="{{ $alarmsJson }}" data-map-notifications="{{ $notificationsJson }}" {{ $attributes }}>
    <div class="map-map {{ $sidebarHidden ? 'w-full' : '' }}" data-map-map>
        <div class="map-map-render" data-map-render></div>
    </div>

    @if ($sidebarHidden === false)

    <div class="map-list box px-5 py-2" data-map-list>
        <div class="flex items-center text-center">
            <div class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600" data-map-list-distance>@unitHuman('distance', $trip->distance)</div>
            <div class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600" data-map-list-time>@timeHuman($trip->time)</div>
            <a href="#" class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600 map-list-toggle" data-map-list-toggle>
                ⟻
            </a>
        </div>

        <table class="table table-report font-medium text-center whitespace-nowrap text-xs" data-map-list-table data-table-sort>
            <thead>
                <tr>
                    <th class="w-1">{{ __('map.date') }}</th>
                    <th class="w-1">{{ __('map.location') }}</th>
                    <th class="w-1">{{ __('map.speed') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($positions->reverse() as $each)

                <tr>
                    <td class="w-1"><a href="#" data-map-point="{{ $each->id }}">{{ $each->date_at }}</a></td>
                    <td class="w-1">{!! $each->latitudeLongitudeLink() !!}</td>
                    <td class="w-1" data-table-sort-value="{{ $each->speed }}">@unitHuman('speed', $each->speed)</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</app-map>
