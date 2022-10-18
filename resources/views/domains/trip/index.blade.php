@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('trip-index.filter') }}" data-table-search="#trip-list-table"/>
        </div>
    </div>
</form>

<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="trip-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="w-1">{{ __('trip-index.id') }}</th>
                <th class="text-left">{{ __('trip-index.name') }}</th>
                <th class="text-center">{{ __('trip-index.start_at') }}</th>
                <th class="text-center">{{ __('trip-index.end_at') }}</th>
                <th class="text-center">{{ __('trip-index.distance') }}</th>
                <th class="text-center">{{ __('trip-index.time') }}</th>
                <th class="text-center">{{ __('trip-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('trip.update.map', $row->id))

            <tr>
                <td class="w-1"><a href="{{ $link }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->id }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap text-left">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->start_at }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->end_at }}</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">@distanceHuman($row->distance)</a></td>
                <td data-table-sort-value="{{ $row->time }}"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">@timeHuman($row->time)</a></td>

                <td class="text-center w-1">
                    <a href="{{ route('trip.update', $row->id) }}">@icon('edit', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ $link }}">@icon('map', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.position', $row->id) }}">@icon('map-pin', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.merge', $row->id) }}">@icon('git-merge', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.export', $row->id) }}">@icon('package', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
