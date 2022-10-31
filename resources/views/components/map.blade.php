<app-map class="map" data-map data-map-id="{{ $trip->id }}" data-map-positions="{{ $json }}" data-map-positions-url="{{ route('trip.update.position', $trip->id) }}" {{ $attributes }}>
    <div class="map-map">
        <div class="map-map-render" data-map-render></div>
    </div>

    <div class="map-list box px-5 py-2">
        <div class="flex items-center text-center">
            <div class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600" map-list-distance>@distanceHuman($trip->distance)</div>
            <div class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600" map-list-time>@timeHuman($trip->time)</div>
        </div>

        <table class="table table-report font-medium text-center whitespace-nowrap text-xs" data-table-sort>
            <thead>
                <tr>
                    <th class="w-1">{{ __('map.date') }}</th>
                    <th class="w-1">{{ __('map.location') }}</th>
                    <th class="w-1">{{ __('map.speed') }}</th>
                    <th class="w-1">{{ __('map.signal') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($positions->reverse() as $each)

                <tr>
                    <td class="w-1"><a href="#" data-map-point="{{ $each->id }}">{{ $each->date_at }}</a></td>
                    <td class="w-1"><a href="https://maps.google.com/?q={{ $each->latitude }},{{ $each->longitude }}" rel="nofollow noopener noreferrer" target="_blank">{{ $each->latitude }},{{ $each->longitude }}</a></td>
                    <td class="w-1">{{ $each->speed }}</td>
                    <td class="w-1">@status((bool)$each->signal)</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</app-map>
