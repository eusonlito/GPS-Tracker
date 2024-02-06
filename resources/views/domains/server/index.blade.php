@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('server-index.filter') }}" data-table-search="#server-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 text-center">
            <a href="{{ route('server.status') }}" class="btn form-control-lg bg-white">{{ __('server-index.status') }}</a>
            <a href="{{ route('server.create') }}" class="btn form-control-lg bg-white ml-2">{{ __('server-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="server-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th>{{ __('server-index.port') }}</th>
                <th>{{ __('server-index.protocol') }}</th>
                <th class="w-1">{{ __('server-index.created_at') }}</th>
                <th class="w-1">{{ __('server-index.debug') }}</th>
                <th class="w-1">{{ __('server-index.enabled') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('server.update', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block">{{ $row->port }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->protocol }}</a></td>
                <td class="w-1" data-table-sort-value="{{ $row->created_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->created_at)</a></td>
                <td class="w-1" data-table-sort-value="{{ (int)$row->debug }}"><a href="{{ route('server.update.boolean', [$row->id, 'debug']) }}" class="block" data-update-boolean="debug">@status($row->debug)</a></td>
                <td class="w-1" data-table-sort-value="{{ (int)$row->enabled }}"><a href="{{ route('server.update.boolean', [$row->id, 'enabled']) }}" class="block" data-update-boolean="enabled">@status($row->enabled)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
