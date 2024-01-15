<app-map class="map map-list-hidden" data-map-refuel data-map-refuel-list="{{ $refuelsJson }}" {{ $attributes }}>
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
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('refuel-map.filter') }}" data-table-search="#map-refuel-list-table-{{ $id }}" />
            </div>
        </form>

        <table id="map-refuel-list-table-{{ $id }}" class="table table-report font-medium text-center whitespace-nowrap text-xs" data-map-list-table data-table-sort>
            <thead>
                <tr>
                    <th class="w-1">{{ __('map-refuel.date_at') }}</th>
                    <th class="w-1">{{ __('map-refuel.vehicle') }}</th>
                    <th class="w-1">{{ __('map-refuel.price') }}</th>
                    <th class="w-1">{{ __('map-refuel.total') }}</th>
                    <th class="w-1"></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($refuels as $each)

                @php ($link = route('refuel.update', $each->id))

                <tr>
                    <td class="w-1" data-table-sort-value={{ $each->date_at }}><a href="#" data-map-point="{{ $each->id }}">@dateLocal($each->date_at)</a></td>
                    <td class="w-1"><a href="#">{{ $each->vehicle->name ?? '-' }}</a></td>
                    <td class="w-1" data-table-sort-value="{{ $each->price }}"><a href="#">@unitHumanRaw('money', $each->price, 3)</a></td>
                    <td class="w-1" data-table-sort-value="{{ $each->total }}"><a href="#">@unitHumanRaw('money', $each->total)</a></td>
                    <td class="w-1 pt-01"><a href="{{ $link }}" class="block">@icon('edit', 'w-4 h-4')</a></td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    @endif
</app-map>
