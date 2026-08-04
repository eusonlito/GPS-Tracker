@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="search" value="{{ $REQUEST->input('search') }}" class="form-control form-control-lg" placeholder="{{ __('expense-index.search') }}" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('expense-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('expense-index.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="expense_category_id" :options="$categories" value="id" text="name" placeholder="{{ __('expense-index.category') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('expense-index.start_at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('expense-index.end_at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <button type="submit" class="btn form-control-lg whitespace-nowrap">{{ __('expense-index.send') }}</button>
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('expense.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('expense-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="expense-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($user_empty)
                <th>{{ __('expense-index.user') }}</th>
                @endif

                @if ($vehicle_empty)
                <th>{{ __('expense-index.vehicle') }}</th>
                @endif

                <th>{{ __('expense-index.category') }}</th>
                <th class="text-left">{{ __('expense-index.name') }}</th>
                <th>{{ __('expense-index.date_at') }}</th>
                <th>{{ __('expense-index.distance') }}</th>
                <th>{{ __('expense-index.amount') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('expense.update', $row->id))

            <tr>
                @if ($user_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->user->name }}</a></td>
                @endif

                @if ($vehicle_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                <td><a href="{{ $link }}" class="block">{{ $row->category->name }}</a></td>
                <td><a href="{{ $link }}" class="block text-left">{{ $row->name }}</a></td>
                <td data-table-sort-value="{{ $row->date_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->date_at)</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block">@if ($row->distance !== null)@unitHumanRaw('distance', $row->distance, 0)@endif</a></td>
                <td data-table-sort-value="{{ $row->amount }}"><a href="{{ $link }}" class="block">@unitHumanRaw('money', $row->amount)</a></td>
            </tr>

            @endforeach
        </tbody>

        @if ($total)

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ 4 + intval($user_empty) + intval($vehicle_empty) }}"></th>
                <th>@unitHumanRaw('money', $total)</th>
            </tr>
        </tfoot>

        @endif
    </table>
</div>

@stop
