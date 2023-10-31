@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('trip-index.filter') }}" data-table-search="#trip-list-table" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        @if ($vehicles_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        @if ($devices_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="device_id" :options="$devices" value="id" text="name" placeholder="{{ __('trip-index.device') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-index.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('trip-index.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="shared" :options="$shared" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="shared_public" :options="$shared_public" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="country_id" :options="$countries" value="id" text="name" placeholder="{{ __('trip-index.country') }}" data-change-submit></x-select>
        </div>

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="state_id" :options="$states" value="id" text="name" placeholder="{{ __('trip-index.state') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($state)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="city_id" :options="$cities" value="id" text="name" placeholder="{{ __('trip-index.city') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="start_end" :options="$starts_ends" placeholder="{{ __('trip-index.start_end') }}" data-change-submit></x-select>
        </div>

        @endif
    </div>

    <div class="box p-5 mt-5">
        <div class="accordion" data-accordion>
            <div class="accordion-item">
                <div class="accordion-header">
                    <button class="accordion-button p-2" type="button" aria-controls="trip-accordion-map">
                        {{ __('trip-index.map') }}
                    </button>
                </div>

                <div class="accordion-collapse collapse {{ $REQUEST->input('fence') ? 'show' : '' }}" aria-labelledby="trip-accordion-map">
                    <div class="accordion-body text-slate-600 dark:text-slate-500 leading-relaxed">
                        <input type="hidden" name="fence" value="{{ $REQUEST->input('fence') ? '1' : '0' }}" />

                        <div class="md:flex">
                            <div class="flex-1 p-2">
                                <label for="trip-index-latitude" class="form-label">{{ __('trip-index.latitude') }}</label>
                                <input type="number" name="fence_latitude" class="form-control form-control-lg" id="trip-index-latitude" value="{{ $REQUEST->input('fence_latitude') ?: $position?->latitude }}" step="any">
                            </div>

                            <div class="flex-1 p-2">
                                <label for="trip-index-longitude" class="form-label">{{ __('trip-index.longitude') }}</label>
                                <input type="number" name="fence_longitude" class="form-control form-control-lg" id="trip-index-longitude" value="{{ $REQUEST->input('fence_longitude') ?: $position?->longitude }}" step="any">
                            </div>

                            <div class="flex-1 p-2">
                                <label for="trip-index-radius" class="form-label">{{ __('trip-index.radius') }}</label>
                                <input type="number" name="fence_radius" class="form-control form-control-lg" id="trip-index-radius" value="{{ $REQUEST->input('fence_radius') ?: 5 }}" step="any">
                            </div>
                        </div>

                        <div class="map-fence mt-5" data-map-fence data-map-fence-latitude="#trip-index-latitude" data-map-fence-longitude="#trip-index-longitude" data-map-fence-radius="#trip-index-radius"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-center">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('trip-search.send') }}</button>
        </div>
    </div>
</form>

@if (isset($list))

<div class="overflow-auto scroll-visible header-sticky">
    <table id="trip-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($vehicles_multiple)
                <th>{{ __('trip-index.vehicle') }}</th>
                @endif

                @if ($devices_multiple)
                <th>{{ __('trip-index.device') }}</th>
                @endif

                <th class="text-left">{{ __('trip-index.name') }}</th>
                <th>{{ __('trip-index.start_at') }}</th>
                <th>{{ __('trip-index.end_at') }}</th>
                <th>{{ __('trip-index.distance') }}</th>
                <th>{{ __('trip-index.time') }}</th>
                <th>{{ __('trip-index.shared') }}</th>
                <th>{{ __('trip-index.shared_public') }}</th>
                <th>{{ __('trip-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('trip.update.map', $row->id))

            <tr>
                @if ($vehicles_multiple)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                @if ($devices_multiple)
                <td><a href="{{ $link }}" class="block">{{ $row->device->name }}</a></td>
                @endif

                <td class="text-left"><a href="{{ $link }}" class="d-t-m-o max-w-md" title="{{ $row->name }}">{{ $row->name }}</a></td>

                <td><a href="{{ $link }}" class="block">{{ $row->start_at }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->end_at }}</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block">@unitHuman('distance', $row->distance)</a></td>
                <td data-table-sort-value="{{ $row->time }}"><a href="{{ $link }}" class="block">@timeHuman($row->time)</a></td>
                <td data-table-sort-value="{{ (int)$row->shared }}" class="w-1"><a href="{{ route('trip.update.boolean', [$row->id, 'shared']) }}" class="block" data-update-boolean="shared">@status($row->shared)</a></td>
                <td data-table-sort-value="{{ (int)$row->shared_public }}" class="w-1"><a href="{{ route('trip.update.boolean', [$row->id, 'shared_public']) }}" class="block" data-update-boolean="shared_public">@status($row->shared_public)</a></td>

                <td class="w-1">
                    <a href="{{ route('trip.update', $row->id) }}">@icon('edit', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.stat', $row->id) }}">@icon('bar-chart-2', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ $link }}">@icon('map', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.position', $row->id) }}">@icon('map-pin', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.alarm-notification', $row->id) }}">@icon('bell', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.merge', $row->id) }}">@icon('git-merge', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.export', $row->id) }}">@icon('package', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ 3 + (int)$vehicles_multiple + (int)$devices_multiple }}"></th>
                <th>@unitHuman('distance', $list->sum('distance'))</th>
                <th>@timeHuman($list->sum('time'))</th>
                <th colspan="3"></th>
            </tr>
        </tfoot>
    </table>
</div>

@endif

@stop
