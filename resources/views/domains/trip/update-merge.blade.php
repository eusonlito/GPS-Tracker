@extends ('domains.trip.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="updateMerge" />

    <div class="box p-5 mt-5">
        <div class="overflow-auto lg:overflow-visible header-sticky">
            <table class="table table-report font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('trip-update-merge.name') }}</th>
                        <th class="text-center">{{ __('trip-update-merge.start_at') }}</th>
                        <th class="text-center">{{ __('trip-update-merge.end_at') }}</th>
                        <th class="text-center">{{ __('trip-update-merge.distance') }}</th>
                        <th class="text-center">{{ __('trip-update-merge.time') }}</th>
                        <th class="text-center">{{ __('trip-update-merge.select') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($list as $each)

                    @php ($link = route('trip.update.map', $each->id))

                    <tr>
                        <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap text-left">{{ $each->name }}</a></td>
                        <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $each->start_at }}</a></td>
                        <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $each->end_at }}</a></td>
                        <td data-table-sort-value="{{ $each->distance }}"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">@distanceHuman($each->distance)</a></td>
                        <td data-table-sort-value="{{ $each->time }}"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">@timeHuman($each->time)</a></td>
                        <td class="w-1">
                            @if ($each->id !== $row->id)
                            <input type="checkbox" name="ids[]" value="{{ $each->id }}" />
                            @endif
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('trip-update-merge.merge') }}</button>
        </div>
    </div>
</form>

@stop
