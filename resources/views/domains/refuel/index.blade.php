@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('refuel-index.filter') }}" data-table-search="#refuel-list-table" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('refuel-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('refuel-index.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('refuel-index.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('refuel-index.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
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

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('refuel.map') }}" class="btn form-control-lg whitespace-nowrap">{{ __('refuel-index.map') }}</a>
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('refuel.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('refuel-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="refuel-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($user_empty)
                <th>{{ __('refuel-index.user') }}</th>
                @endif

                @if ($vehicle_empty)
                <th>{{ __('refuel-index.vehicle') }}</th>
                @endif

                <th>{{ __('refuel-index.date_at') }}</th>
                <th>{{ __('refuel-index.distance_total') }}</th>
                <th>{{ __('refuel-index.distance') }}</th>
                <th>{{ __('refuel-index.quantity') }}</th>
                <th>{{ __('refuel-index.price') }}</th>
                <th>{{ __('refuel-index.total') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('refuel.update', $row->id))

            <tr>
                @if ($user_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->user->name }}</a></td>
                @endif

                @if ($vehicle_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                <td data-table-sort-value="{{ $row->date_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->date_at)</a></td>
                <td data-table-sort-value="{{ $row->distance_total }}"><a href="{{ $link }}" class="block">@unitHumanRaw('distance', $row->distance_total, 0)</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block">@unitHumanRaw('distance', $row->distance, 0)</a></td>
                <td data-table-sort-value="{{ $row->quantity }}"><a href="{{ $link }}" class="block">@unitHumanRaw('volume', $row->quantity)</a></td>
                <td data-table-sort-value="{{ $row->price }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $row->price, 3)</a></td>
                <td data-table-sort-value="{{ $row->total }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $row->total)</a></td>
            </tr>

            @endforeach
        </tbody>

        @if ($totals)

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ 2 + intval($user_empty) + intval($vehicle_empty) }}"></th>
                <th>@unitHumanRaw('distance', $totals->distance, 0)</th>
                <th>@unitHumanRaw('volume', $totals->quantity)</th>
                <th>@unitHumanRaw('money', $totals->price, 3)</th>
                <th>@unitHumanRaw('money', $totals->total)</th>
            </tr>
        </tfoot>

        @endif
    </table>
</div>

@stop
