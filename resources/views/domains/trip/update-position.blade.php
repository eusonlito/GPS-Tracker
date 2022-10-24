@extends ('domains.trip.update-layout')

@section ('content')

<form method="get">
    <input type="search" class="form-control form-control-lg mt-4" placeholder="{{ __('trip-update-position.filter') }}" data-table-search="#position-list-table"/>
</form>

<form method="post">
    <div class="box p-5 mt-5">
        <div class="overflow-auto lg:overflow-visible header-sticky">
            <table id="position-list-table" class="table table-report font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                <thead>
                    <tr>
                        <th class="w-1">{{ __('trip-update-position.date') }}</th>
                        <th class="w-1">{{ __('trip-update-position.location') }}</th>
                        <th class="w-1">{{ __('trip-update-position.city') }}</th>
                        <th class="w-1">{{ __('trip-update-position.speed') }}</th>
                        <th class="w-1">{{ __('trip-update-position.signal') }}</th>
                        <th class="w-1"><input type="checkbox" data-checkall="#position-list-table > tbody" /></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($positions as $each)

                    <tr>
                        <td class="w-1">{{ $each->date_at }}</td>
                        <td class="w-1"><a href="https://maps.google.com/?q={{ $each->latitude }},{{ $each->longitude }}" rel="nofollow noopener noreferrer" target="_blank">{{ $each->latitude }},{{ $each->longitude }}</a></td>
                        <td class="w-1">{{ $each->city->name }} ({{ $each->city->state->name }})</td>
                        <td class="w-1">{{ $each->speed }}</td>
                        <td class="w-1">@status((bool)$each->signal)</td>
                        <td class="w-1"><input type="checkbox" name="position_ids[]" value="{{ $each->id }}" /></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" name="_action" value="updatePositionDelete" class="btn btn-outline-danger mr-5">{{ __('trip-update-position.delete') }}</button>
            <button type="submit" name="_action" value="updatePositionCreate" class="btn btn-primary">{{ __('trip-update-position.create') }}</button>
        </div>
    </div>
</form>

@stop
