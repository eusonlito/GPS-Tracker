@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('ip-lock-index.filter') }}" data-table-search="#ip-lock-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('ip-lock.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('ip-lock-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="ip-lock-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="ip-lock-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('ip-lock-index.ip') }}</th>
                <th>{{ __('ip-lock-index.created_at') }}</th>
                <th>{{ __('ip-lock-index.end_at') }}</th>
                <th>{{ __('ip-lock-index.time') }}</th>
                <th>{{ __('ip-lock-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('ip-lock.update', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block">{{ $row->ip }}</a></td>
                <td data-table-sort-value="{{ $row->created_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->created_at)</a></td>
                <td data-table-sort-value="{{ $row->end_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->end_at)</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->time() }}</a></td>
                <td class="w-1">
                    @if ($row->finished() === false)
                    <a href="{{ route('ip-lock.update.end-at', $row->id) }}" title="{{ __('ip-lock-index.unlock') }}" class="block">@icon('unlock', 'w-4 h-4')</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="ip-lock-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
