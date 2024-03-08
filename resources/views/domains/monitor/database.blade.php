@extends ('layouts.in')

@section ('body')

<div class="overflow-auto scroll-visible text-center header-sticky">
    <table class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="text-left">{{ __('monitor-database.table_name') }}</th>
                <th>{{ __('monitor-database.total_size') }}</th>
                <th>{{ __('monitor-database.table_size') }}</th>
                <th>{{ __('monitor-database.index_size') }}</th>
                <th>{{ __('monitor-database.table_rows') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($sizes as $each)

            <tr>
                <td class="text-left">{{ $each->table_name }}</td>
                <td data-table-sort-value="{{ $each->total_size }}" >@number($each->total_size) MB</td>
                <td data-table-sort-value="{{ $each->table_size }}" >@number($each->table_size) MB</td>
                <td data-table-sort-value="{{ $each->index_size }}" >@number($each->index_size) MB</td>
                <td data-table-sort-value="{{ $counts[$each->table_name] }}" >@number($counts[$each->table_name], 0)</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
