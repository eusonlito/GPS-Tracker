@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('refuel-index.filter') }}" data-table-search="#refuel-list-table" />
        </div>

        @if ($devices_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="device_id" :options="$devices" value="id" text="name" :placeholder="__('refuel-index.device')" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="year" :options="$years" :placeholder="__('common.year')" value-only data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="month" :options="$months" :placeholder="__('common.month')" data-change-submit></x-select>
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('refuel.create') }}" class="btn form-control-lg">{{ __('refuel-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="refuel-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                @if ($devices_multiple)
                <th>{{ __('refuel-index.device') }}</th>
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
                @if ($devices_multiple)
                <td><a href="{{ $link }}" class="block">{{ $row->device->name }}</a></td>
                @endif

                <td><a href="{{ $link }}" class="block">{{ $row->date_at }}</a></td>
                <td><a href="{{ $link }}" class="block">@distanceHuman($row->distance_total * 1000, 0)</a></td>
                <td><a href="{{ $link }}" class="block">@distanceHuman($row->distance * 1000, 0)</a></td>
                <td><a href="{{ $link }}" class="block">@number($row->quantity)</a></td>
                <td><a href="{{ $link }}" class="block">@money($row->price, 3)</a></td>
                <td><a href="{{ $link }}" class="block">@money($row->total)</a></td>
            </tr>

            @endforeach
        </tbody>

        @if ($totals)

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ $devices_multiple ? '3' : '2' }}"></th>
                <th>@distanceHuman($totals->distance * 1000, 0)</th>
                <th>@number($totals->quantity)</th>
                <th>@money($totals->price, 3)</th>
                <th>@money($totals->total)</th>
            </tr>
        </tfoot>

        @endif
    </table>
</div>

@stop
