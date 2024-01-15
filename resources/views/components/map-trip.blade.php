<app-map class="map map-list-hidden" data-map-trip {{ $attributes }}>
    <div class="map-map {{ $sidebarHidden ? 'w-full' : '' }}" data-map-map>
        <div class="map-map-render" data-map-render data-map-control-markers-disabled></div>
    </div>

    @if ($sidebarHidden === false)

    <div class="map-list map-list-large box px-5 py-2" data-map-list>
        <div class="flex items-center text-center">
            <a href="#" class="flex-1 mx-2 py-1 px-2 rounded-full border font-medium text-slate-600 map-list-toggle" data-map-list-toggle>
                ⟻
            </a>
        </div>

        <form method="get">
            <div class="p-2">
                <input type="search" class="form-control form-control-lg" placeholder="{{ __('trip-map.filter') }}" data-table-search="#map-trip-list-table-{{ $id }}" />
            </div>
        </form>

        <table id="map-trip-list-table-{{ $id }}" class="table table-report font-medium text-center whitespace-nowrap text-xs" data-map-list-table data-table-sort>
            <thead>
                <tr>
                    <th class="w-1">{{ __('map-trip.start_at') }}</th>
                    <th class="w-1">{{ __('map-trip.distance') }}</th>
                    <th class="w-1">{{ __('map-trip.time') }}</th>
                    <th class="w-1 {{ $deviceShow ? '' : 'hidden' }}">{{ __('map-trip.device') }}</th>
                    <th class="w-1 {{ $vehicleShow ? '' : 'hidden' }}">{{ __('map-trip.vehicle') }}</th>
                    <th class="w-1 {{ $vehicleShow ? '' : 'hidden' }}">{{ __('map-trip.plate') }}</th>
                    <th class="w-1 {{ $userShow ? '' : 'hidden' }}">{{ __('map-trip.user') }}</th>
                    <th class="w-1"></th>
                </tr>
            </thead>

            <tbody>
                <tr class="hidden">
                    <td class="w-1 cursor-pointer"></td>
                    <td class="w-1"></td>
                    <td class="w-1"></td>
                    <td class="w-1 {{ $deviceShow ? '' : 'hidden' }}"></td>
                    <td class="w-1 {{ $vehicleShow ? '' : 'hidden' }}"></td>
                    <td class="w-1 {{ $vehicleShow ? '' : 'hidden' }}"></td>
                    <td class="w-1 {{ $userShow ? '' : 'hidden' }}"></td>
                    <td class="w-1 pt-01"><a href="{{ route('trip.update', '0') }}" class="block">@icon('edit', 'w-4 h-4')</a></td>
                </tr>
            </tbody>
        </table>
    </div>

    @endif
</app-map>
