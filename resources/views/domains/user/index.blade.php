@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-index.filter') }}" data-table-search="#user-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('user.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('user-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="user-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="user-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th class="text-left">{{ __('user-index.name') }}</th>
                <th class="text-left">{{ __('user-index.email') }}</th>
                <th>{{ __('user-index.created_at') }}</th>
                <th>{{ __('user-index.updated_at') }}</th>
                <th>{{ __('user-index.manager') }}</th>
                <th>{{ __('user-index.admin') }}</th>
                <th>{{ __('user-index.enabled') }}</th>
                <th>{{ __('user-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('user.update', $row->id))

            <tr>
                <td class="text-left"><a href="{{ $link }}" class="block">{{ $row->name }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block">{{ $row->email }}</a></td>
                <td data-table-sort-value="{{ $row->created_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->created_at)</a></td>
                <td data-table-sort-value="{{ $row->updated_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->updated_at)</a></td>
                <td data-table-sort-value="{{ intval($row->admin) }}">@status($row->manager)</td>
                <td data-table-sort-value="{{ intval($row->admin) }}">@status($row->admin)</td>
                <td data-table-sort-value="{{ intval($row->enabled) }}">@status($row->enabled)</td>
                <td class="w-1">
                    <a href="{{ route('user.update.user-session', $row->id) }}">@icon('key', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="user-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
