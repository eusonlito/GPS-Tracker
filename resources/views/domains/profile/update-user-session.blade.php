@extends ('domains.profile.update-layout')

@section ('content')

<div class="overflow-auto scroll-visible header-sticky">
    <table id="profile-update-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-pagination="profile-update-list-table-pagination" data-table-sort>
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
                <td data-table-sort-value="{{ $each->created_at }}">@dateWithUserTimezone($each->created_at)</td>
                <td>{{ $each->ip }}</td>
                <td data-table-sort-value="{{ (int)$each->success }}">@status($each->success)</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="profile-update-list-table-pagination" class="pagination justify-end"></ul>
</div>

@stop
