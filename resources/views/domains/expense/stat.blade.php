@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('expense-stat.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('expense-stat.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="start_at" value="{{ $REQUEST->input('start_at') }}" class="form-control form-control-lg" placeholder="{{ __('expense-stat.start_at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" name="end_at" value="{{ $REQUEST->input('end_at') }}" class="form-control form-control-lg" placeholder="{{ __('expense-stat.end_at') }}" data-datepicker data-datepicker-min-date="{{ $date_min }}" data-change-submit />
        </div>

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <button type="submit" class="btn form-control-lg whitespace-nowrap">{{ __('expense-stat.send') }}</button>
        </div>
    </div>
</form>

@if ($stats)

<div class="box p-5 mt-5 lg:flex lg:items-end lg:justify-between">
    <div>
        <div class="text-slate-500">{{ __('expense-stat.stats.total') }}</div>
        <div class="text-3xl font-medium mt-2">@unitHumanRaw('money', $stats->total)</div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mt-5 lg:mt-0 lg:gap-8">
        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.amount_per_day') }}</div>
            <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->amount_per_day)</div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.amount_per_month') }}</div>
            <div class="text-xl font-medium mt-1">@unitHumanRaw('money', $stats->amount_per_month)</div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.amount_per_distance') }}</div>
            <div class="text-xl font-medium mt-1">
                @if (is_null($stats->amount_per_distance))
                —
                @else
                @unitHumanRaw('money', $stats->amount_per_distance, 4)
                @endif
            </div>
        </div>
    </div>
</div>

<div class="box mt-5">
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-5 p-5">
        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.start_at') }}</div>
            <div class="text-xl font-medium mt-1">@dateLocal($stats->start_at)</div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.end_at') }}</div>
            <div class="text-xl font-medium mt-1">@dateLocal($stats->end_at)</div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.days') }}</div>
            <div class="text-xl font-medium mt-1">@dateDiffHuman($stats->start_at, $stats->end_at)</div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.distance_start') }}</div>
            <div class="text-xl font-medium mt-1">
                @if (is_null($stats->distance_start))
                —
                @else
                @unitHumanRaw('distance', $stats->distance_start, 0)
                @endif
            </div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.distance_end') }}</div>
            <div class="text-xl font-medium mt-1">
                @if (is_null($stats->distance_end))
                —
                @else
                @unitHumanRaw('distance', $stats->distance_end, 0)
                @endif
            </div>
        </div>

        <div>
            <div class="text-slate-500 text-sm">{{ __('expense-stat.stats.distance') }}</div>
            <div class="text-xl font-medium mt-1">
                @if (is_null($stats->distance))
                —
                @else
                @unitHumanRaw('distance', $stats->distance, 0)
                @endif
            </div>
        </div>
    </div>
</div>

<div class="box mt-5">
    <div class="p-5">
        @foreach ($stats->categories as $category)

        @php ($link = route('expense.index', array_filter([
            'user_id' => $REQUEST->input('user_id'),
            'vehicle_id' => $REQUEST->input('vehicle_id'),
            'start_at' => $stats->start_at,
            'end_at' => $stats->end_at,
            'expense_category_id' => $category->id,
        ], static fn ($value) => ($value !== null) && ($value !== ''))))

        <a href="{{ $link }}" class="block {{ $loop->last ? '' : 'mb-5 pb-5 border-b border-slate-200/60' }} hover:opacity-80">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-end lg:gap-6">
                <div class="min-w-0 flex-1">
                    <div class="font-medium truncate">{{ $category->name }}</div>
                    <div class="text-slate-400 text-sm mt-1">{{ __('expense-stat.stats.count', ['count' => $category->count]) }}</div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 lg:gap-6 shrink-0">
                    <div class="text-center px-3">
                        <div class="text-slate-500 text-xs">{{ __('expense-stat.stats.total') }}</div>
                        <div class="text-sm font-medium mt-1 whitespace-nowrap">@unitHumanRaw('money', $category->amount)</div>
                    </div>

                    <div class="text-center px-3">
                        <div class="text-slate-500 text-xs">{{ __('expense-stat.stats.amount_per_day') }}</div>
                        <div class="text-sm font-medium mt-1 whitespace-nowrap">@unitHumanRaw('money', $category->amount_per_day)</div>
                    </div>

                    <div class="text-center px-3">
                        <div class="text-slate-500 text-xs">{{ __('expense-stat.stats.amount_per_month') }}</div>
                        <div class="text-sm font-medium mt-1 whitespace-nowrap">@unitHumanRaw('money', $category->amount_per_month)</div>
                    </div>

                    <div class="text-center px-3">
                        <div class="text-slate-500 text-xs">{{ __('expense-stat.stats.amount_per_distance') }}</div>
                        <div class="text-sm font-medium mt-1 whitespace-nowrap">
                            @if (is_null($category->amount_per_distance))
                            —
                            @else
                            @unitHumanRaw('money', $category->amount_per_distance, 4)
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="progress h-6 mt-3">
                <div class="progress-bar p-3 whitespace-nowrap" style="width: {{ $category->percent }}%" role="progressbar" aria-valuenow="{{ $category->percent }}" aria-valuemin="0" aria-valuemax="100">{{ __('expense-stat.stats.percent', ['percent' => $category->percent]) }}</div>
            </div>
        </a>

        @endforeach
    </div>
</div>

@else

<div class="box p-5 mt-5 text-center text-slate-500">
    {{ __('expense-stat.empty') }}
</div>

@endif

@stop
