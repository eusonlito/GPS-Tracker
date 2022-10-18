<app-map class="map" data-map data-map-id="{{ $id }}" data-map-positions="{{ $json }}" data-map-positions-url="{{ route('trip.update.position', $id) }}" {{ $attributes }}>
    <div class="map-map">
        <div class="map-map-render" data-map-render></div>
    </div>

    <div class="map-list box p-5">
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
