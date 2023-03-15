@extends ('layouts.in')

@section ('body')

<div class="flex-grow mt-2 sm:mt-0">
    <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-ip-lock.filter') }}" data-table-search="#ip-lock-list-table" />
</div>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="ip-lock-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="ip-lock-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('user-ip-lock.ip') }}</th>
                <th>{{ __('user-ip-lock.created_at') }}</th>
                <th>{{ __('user-ip-lock.end_at') }}</th>
                <th>{{ __('user-ip-lock.time') }}</th>
                <th>{{ __('user-ip-lock.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($locks as $each)

            @php ($link = $each->user ? route('user.update', $each->id) : null)

            <tr>
                <td>{{ $each->ip }}</td>
                <td data-table-sort-value="{{ $each->created_at }}">@dateWithTimezone($each->created_at)</td>
                <td data-table-sort-value="{{ $each->end_at }}">@dateWithTimezone($each->end_at)</td>
                <td>{{ $each->time() }}</td>
                <td class="w-1">
                    @if ($each->finished() === false)
                    <a href="{{ route('ip-lock.update.end-at', $each->id) }}" title="{{ __('user-ip-lock.unlock') }}" class="block">@icon('unlock', 'w-4 h-4')</a>
                    @endif
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="ip-lock-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
