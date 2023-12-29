@extends ('layouts.in')

@section ('body')

<input type="search" class="form-control form-control-lg" placeholder="{{ __('state-index.filter') }}" data-table-search="#state-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <table id="state-list-table" class="table table-report sm:mt-2 font-medium text-center font-semibold whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left">{{ __('state-index.name') }}</th>
                <th class="text-left">{{ __('state-index.alias') }}</th>
                <th class="text-left">{{ __('state-index.country') }}</th>
                <th class="text-left">{{ __('state-index.created_at') }}</th>
                <th class="text-left">{{ __('state-index.updated_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('state.update', $row->id))

            <tr>
                <td class="text-left"><a href="{{ $link }}" class="block">{{ $row->name }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block">{{ implode(', ', $row->alias ?? []) }}</a></td>
                <td class="text-left">{{ $row->country->name }}</td>
                <td class="w-1" data-table-sort-value="{{ $row->created_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->created_at)</a></td>
                <td class="w-1" data-table-sort-value="{{ $row->updated_at }}"><a href="{{ $link }}" class="block">@dateLocal($row->updated_at)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
