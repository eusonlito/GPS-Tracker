@extends ('layouts.in')

@section ('body')

<div class="flex-grow mt-2 sm:mt-0">
    <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-session-index.filter') }}" data-table-search="#user-session-list-table" />
</div>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="user-session-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="user-session-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('user-session-index.created_at') }}</th>
                <th>{{ __('user-session-index.auth') }}</th>
                <th>{{ __('user-session-index.ip') }}</th>
                <th>{{ __('user-session-index.success') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = $row->user ? route('user.update', $row->user->id) : null)

            <tr>
                <td data-table-sort-value="{{ $row->created_at }}">@dateWithUserTimezone($row->created_at)</td>
                <td>
                    @if ($link)
                    <a href="{{ $link }}">{{ $row->auth }}</a>
                    @else
                    {{ $row->auth }}
                    @endif
                </td>
                <td>{{ $row->ip }}</td>
                <td data-table-sort-value="{{ (int)$row->success }}">@status($row->success)</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="user-session-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
