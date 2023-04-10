@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('refuel-index.filter') }}" data-table-search="#refuel-list-table" />
        </div>

        @if ($vehicles_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" :placeholder="__('refuel-index.vehicle')" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('refuel-index.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('refuel-index.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('refuel.create') }}" class="btn form-control-lg">{{ __('refuel-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="refuel-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($vehicles_multiple)
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
                @if ($vehicles_multiple)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                <td><a href="{{ $link }}" class="block">{{ $row->date_at }}</a></td>
                <td><a href="{{ $link }}" class="block" data-sort-table-value="{{ $row->distance_total }}">@unitHumanRaw('distance', $row->distance_total, 0)</a></td>
                <td><a href="{{ $link }}" class="block" data-sort-table-value="{{ $row->distance }}">@unitHumanRaw('distance', $row->distance, 0)</a></td>
                <td><a href="{{ $link }}" class="block" data-sort-table-value="{{ $row->quantity }}">@unitHumanRaw('volume', $row->quantity)</a></td>
                <td><a href="{{ $link }}" class="block" data-sort-table-value="{{ $row->price }}">@unitHumanRaw('money', $row->price, 3)</a></td>
                <td><a href="{{ $link }}" class="block" data-sort-table-value="{{ $row->total }}">@unitHumanRaw('money', $row->total)</a></td>
            </tr>

            @endforeach
        </tbody>

        @if ($totals)

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ $vehicles_multiple ? '3' : '2' }}"></th>
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
