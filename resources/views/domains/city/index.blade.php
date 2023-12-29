@extends ('layouts.in')

@section ('body')

<input type="search" class="form-control form-control-lg" placeholder="{{ __('city-index.filter') }}" data-table-search="#city-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <table id="city-list-table" class="table table-report sm:mt-2 font-medium text-center font-semibold whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left">{{ __('city-index.name') }}</th>
                <th class="text-left">{{ __('city-index.alias') }}</th>
                <th class="text-left">{{ __('city-index.state') }}</th>
                <th class="text-left">{{ __('city-index.country') }}</th>
                <th>{{ __('city-index.coordinates') }}</th>
                <th>{{ __('city-index.created_at') }}</th>
                <th>{{ __('city-index.updated_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('city.update', $row->id))

            <tr>
                <td class="text-left"><a href="{{ $link }}" class="block">{{ $row->name }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block">{{ implode(', ', $row->alias ?? []) }}</a></td>
                <td class="text-left">{{ $row->state->name }}</td>
                <td class="text-left">{{ $row->country->name }}</td>
                <td>{!! $row->latitudeLongitudeLink() !!}</td>
                <td class="w-1" data-table-sort-value="{{ $row->created_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->created_at)</a></td>
                <td class="w-1" data-table-sort-value="{{ $row->updated_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->updated_at)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
