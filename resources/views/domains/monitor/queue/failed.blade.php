@extends ('domains.monitor.queue.layout')

@section ('content')

<input type="search" class="form-control form-control-lg" placeholder="{{ __('common.filter') }}" data-table-search="#monitor-queue-table"/>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="monitor-queue-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr class="text-muted text-capital">
                <th class="w-1 text-center">{{ __('monitor-queue.id') }}</th>
                <th>{{ __('monitor-queue.name') }}</th>
                <th class="w-1 text-center">{{ __('monitor-queue.failed_at') }}</th>
                <th class="w-1 text-center">{{ __('monitor-queue.actions') }}</th>
            </tr>
        </thead>

        <tbody class="text-gray-800">
            @foreach ($list as $each)

            <tr>
                <td class="w-1 text-center">{{ $each->id }}</td>
                <td>{{ $each->payload['displayName'] }}</td>
                <td class="w-1 text-center">{{ $each->failed_at }}</td>
                <td class="text-center w-1">
                    <form method="post">
                        <input type="hidden" name="id" value="{{ $each->id }}" />

                        <button type="submit" name="_action" value="failedRetry" title="{{ __('monitor-queue.retry') }}" class="btn btn-icon btn-active-icon-primary btn-icon-dark btn-sm">
                            @icon('refresh', 'w-4 h-4')
                        </button>
                    </form>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
