@extends ('domains.profile.update-layout')

@section ('content')

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="user-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="user-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('profile-update-user-session.created_at') }}</th>
                <th>{{ __('profile-update-user-session.ip') }}</th>
                <th>{{ __('profile-update-user-session.success') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($sessions as $each)

            <tr>
                <td data-table-sort-value="{{ $each->created_at }}">@dateWithTimezone($each->created_at)</td>
                <td>{{ $each->ip }}</td>
                <td data-table-sort-value="{{ (int)$each->success }}">@status($each->success)</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="user-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
