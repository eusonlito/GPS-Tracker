@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="search" value="{{ $REQUEST->input('search') }}" class="form-control form-control-lg" placeholder="{{ __('maintenance-index.search') }}" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('maintenance-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('maintenance-index.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('maintenance-index.start-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('maintenance-index.end-at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <button type="submit" class="btn form-control-lg whitespace-nowrap">{{ __('maintenance-index.send') }}</button>
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('maintenance.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('maintenance-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="maintenance-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($user_empty)
                <th>{{ __('maintenance-index.user') }}</th>
                @endif

                @if ($vehicle_empty)
                <th>{{ __('maintenance-index.vehicle') }}</th>
                @endif

                <th class="text-left">{{ __('maintenance-index.name') }}</th>
                <th>{{ __('maintenance-index.workshop') }}</th>
                <th>{{ __('maintenance-index.date_at') }}</th>
                <th>{{ __('maintenance-index.distance') }}</th>
                <th>{{ __('maintenance-index.distance_next') }}</th>
                <th>{{ __('maintenance-index.amount') }}</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('maintenance.update', $row->id))

            <tr>
                @if ($user_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->user->name }}</a></td>
                @endif

                @if ($vehicle_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                <td><a href="{{ $link }}" class="block text-left">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->workshop }}</a></td>
                <td data-table-sort-value="{{ $row->date_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->date_at)</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block">@unitHumanRaw('distance', $row->distance, 0)</a></td>
                <td data-table-sort-value="{{ $row->distance_next }}"><a href="{{ $link }}" class="block">@unitHumanRaw('distance', $row->distance_next, 0)</a></td>
                <td data-table-sort-value="{{ $row->amount }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $row->amount, 2)</a></td>

                <td class="w-1">
                    <a href="{{ route('maintenance.update.item', $row->id) }}">@icon('shopping-bag', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>

        @if ($total)

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ 5 + intval($user_empty) + intval($vehicle_empty) }}"></th>
                <th>@unitHumanRaw('money', $total)</th>
                <th></th>
            </tr>
        </tfoot>

        @endif
    </table>
</div>

@stop
