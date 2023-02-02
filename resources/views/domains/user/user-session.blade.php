@extends ('layouts.in')

@section ('body')

<div class="flex-grow mt-2 sm:mt-0">
    <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-user-session.filter') }}" data-table-search="#user-session-list-table" />
</div>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="user-session-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="user-session-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('user-user-session.created_at') }}</th>
                <th>{{ __('user-user-session.auth') }}</th>
                <th>{{ __('user-user-session.ip') }}</th>
                <th>{{ __('user-user-session.success') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($sessions as $each)

            @php ($link = $each->user ? route('user.update', $each->id) : null)

            <tr>
                <td data-table-sort-value="{{ $each->created_at }}">@dateWithTimezone($each->created_at)</td>
                <td>
                    @if ($link)
                    <a href="{{ $link }}">{{ $each->auth }}</a>
                    @else
                    {{ $each->auth }}
                    @endif
                </td>
                <td>{{ $each->ip }}</td>
                <td data-table-sort-value="{{ (int)$each->success }}">@status($each->success)</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="user-session-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
