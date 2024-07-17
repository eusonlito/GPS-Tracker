@extends ('domains.monitor.queue.layout')

@section ('content')

<input type="search" class="form-control form-control-lg" placeholder="{{ __('common.filter') }}" data-table-search="#monitor-queue-table"/>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="monitor-queue-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr class="text-muted text-capital">
                <th>{{ __('monitor-queue.name') }}</th>
                <th class="text-center">{{ __('monitor-queue.created_at') }}</th>
                <th class="text-center">{{ __('monitor-queue.attempts') }}</th>
                <th class="text-center">{{ __('monitor-queue.max_tries') }}</th>
                <th class="text-center">{{ __('monitor-queue.timeout') }}</th>
            </tr>
        </thead>

        <tbody class="text-gray-800">
            @foreach ($list as $each)

            <tr>
                <td>{{ $each->displayName }}</td>
                <td class="text-center">{{ date('c', $each->retryUntil) }}</td>
                <td class="text-center">{{ $each->attempts }}</td>
                <td class="text-center">{{ $each->maxTries }}</td>
                <td class="text-center">{{ $each->timeout }}</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
