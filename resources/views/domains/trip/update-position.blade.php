@extends ('domains.trip.update-layout')

@section ('content')

<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 lg:col-span-5 mt-5">
        <x-map
            :trip="$row"
            :positions="$positions"
            :alarms="$alarms"
            :notifications="$notifications"
            sidebar-hidden
        ></x-map>
    </div>

    <div class="col-span-12 lg:col-span-7 mt-5">
        <form method="get">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('trip-update-position.filter') }}" data-table-search="#position-list-table"/>
        </form>

        <form method="post">
            <div class="box p-5 mt-5">
                <div class="overflow-auto scroll-visible header-sticky">
                    <table id="position-list-table" class="table table-report font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                        <thead>
                            <tr>
                                <th class="w-1">{{ __('trip-update-position.date') }}</th>
                                <th class="w-1">{{ __('trip-update-position.location') }}</th>
                                <th>{{ __('trip-update-position.city') }}</th>
                                <th class="w-1">{{ __('trip-update-position.speed') }}</th>
                                <th class="w-1">{{ __('trip-update-position.signal') }}</th>
                                <th class="w-1"><input type="checkbox" data-checkall="#position-list-table > tbody" /></th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($positions as $each)

                            <tr>
                                <td class="w-1"><a href="#" data-map-point="{{ $each->id }}">{{ $each->date_at }}</a></td>
                                <td class="w-1">{!! $each->latitudeLongitudeLink() !!}</td>
                                <td>
                                    @if ($each->city)
                                    <span class="d-t-m-o max-w-15" title="{{ $each->city->name }} ({{ $each->city->state->name }})">{{ $each->city->name }} ({{ $each->city->state->name }})</span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="w-1" data-table-sort-value="{{ $each->speed }}">@unitHuman('speed', $each->speed)</td>
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
    </div>
</div>

@stop
