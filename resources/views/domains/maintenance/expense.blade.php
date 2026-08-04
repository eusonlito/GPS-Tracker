@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('maintenance-expense.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('maintenance-expense.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('maintenance-expense.start_at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('maintenance-expense.end_at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <button type="submit" class="btn form-control-lg whitespace-nowrap">{{ __('maintenance-expense.send') }}</button>
        </div>
    </div>
</form>

@if ($stats)

<div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4 mt-5">
    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.distance_start') }}</div>
        <div class="text-xl font-medium mt-1">
            @if (is_null($stats->distance_start))
            —
            @else
            @unitHumanRaw('distance', $stats->distance_start, 0)
            @endif
        </div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.distance_end') }}</div>
        <div class="text-xl font-medium mt-1">
            @if (is_null($stats->distance_end))
            —
            @else
            @unitHumanRaw('distance', $stats->distance_end, 0)
            @endif
        </div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.distance') }}</div>
        <div class="text-xl font-medium mt-1">
            @if (is_null($stats->distance))
            —
            @else
            @unitHumanRaw('distance', $stats->distance, 0)
            @endif
        </div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.days') }}</div>
        <div class="text-xl font-medium mt-1">@dateDiffHuman($stats->start_at, $stats->end_at)</div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.maintenance_amount') }}</div>
        <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->maintenance_amount)</div>
        <div class="text-slate-400 text-sm mt-1">{{ __('maintenance-expense.stats.count', ['count' => $stats->maintenance_count]) }}</div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.refuel_amount') }}</div>
        <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->refuel_amount)</div>
        <div class="text-slate-400 text-sm mt-1">{{ __('maintenance-expense.stats.count', ['count' => $stats->refuel_count]) }} · @unitHumanRaw('volume', $stats->refuel_quantity)</div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.total') }}</div>
        <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->total)</div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.amount_per_distance') }}</div>
        <div class="text-xl font-medium mt-1">
            @if (is_null($stats->amount_per_distance))
            —
            @else
            @unitHumanRaw('money', $stats->amount_per_distance, 4)
            @endif
        </div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.amount_per_day') }}</div>
        <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->amount_per_day)</div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.amount_per_month') }}</div>
        <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->amount_per_month)</div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.maintenance_amount_per_distance') }}</div>
        <div class="text-xl font-medium mt-1">
            @if (is_null($stats->maintenance_amount_per_distance))
            —
            @else
            @unitHumanRaw('money', $stats->maintenance_amount_per_distance, 4)
            @endif
        </div>
    </div>

    <div class="box p-5">
        <div class="text-slate-500">{{ __('maintenance-expense.stats.refuel_amount_per_distance') }}</div>
        <div class="text-xl font-medium mt-1">
            @if (is_null($stats->refuel_amount_per_distance))
            —
            @else
            @unitHumanRaw('money', $stats->refuel_amount_per_distance, 4)
            @endif
        </div>
    </div>
</div>

@endif

<div class="overflow-auto scroll-visible header-sticky">
    <table id="maintenance-expense-list-table" class="table table-report sm:mt-5 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($user_empty)
                <th>{{ __('maintenance-expense.user') }}</th>
                @endif

                @if ($vehicle_empty)
                <th>{{ __('maintenance-expense.vehicle') }}</th>
                @endif

                <th>{{ __('maintenance-expense.type') }}</th>
                <th class="text-left">{{ __('maintenance-expense.name') }}</th>
                <th>{{ __('maintenance-expense.date_at') }}</th>
                <th>{{ __('maintenance-expense.distance') }}</th>
                <th>{{ __('maintenance-expense.quantity') }}</th>
                <th>{{ __('maintenance-expense.amount') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                @if ($user_empty)
                <td><a href="{{ $row->route }}" class="block">{{ $row->user->name }}</a></td>
                @endif

                @if ($vehicle_empty)
                <td><a href="{{ $row->route }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                <td><a href="{{ $row->route }}" class="block">{{ __('maintenance-expense.type-'.$row->type) }}</a></td>
                <td><a href="{{ $row->route }}" class="block text-left">{{ $row->name ?: $row->workshop ?: '—' }}</a></td>
                <td data-table-sort-value="{{ $row->date_at }}"><a href="{{ $row->route }}" class="block">@dateLocal($row->date_at)</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $row->route }}" class="block">@unitHumanRaw('distance', $row->distance, 0)</a></td>
                <td data-table-sort-value="{{ $row->quantity }}">
                    <a href="{{ $row->route }}" class="block">
                        @if (is_null($row->quantity))
                        —
                        @else
                        @unitHumanRaw('volume', $row->quantity)
                        @endif
                    </a>
                </td>
                <td data-table-sort-value="{{ $row->amount }}"><a href="{{ $row->route }}" class="block">@unitHumanRaw('money', $row->amount)</a></td>
            </tr>

            @endforeach
        </tbody>

        @if ($stats)

        <tfoot class="bg-white">
            <tr>
                <th colspan="{{ 4 + intval($user_empty) + intval($vehicle_empty) }}"></th>
                <th>
                    @if (is_null($stats->refuel_quantity))
                    —
                    @else
                    @unitHumanRaw('volume', $stats->refuel_quantity)
                    @endif
                </th>
                <th>@unitHumanRaw('money', $stats->total)</th>
            </tr>
        </tfoot>

        @endif
    </table>
</div>

@stop
