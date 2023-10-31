@extends ('layouts.in')

@section ('body')

<input type="search" class="form-control form-control-lg" placeholder="{{ __('timezone-index.filter') }}" data-table-search="#timezone-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <table id="timezone-list-table" class="table table-report sm:mt-2 font-medium text-center font-semibold whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left">{{ __('timezone-index.zone') }}</th>
                <th>{{ __('timezone-index.default') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                <td class="text-left">{{ $row->zone }}</td>
                <td class="w-1"><a href="{{ route('timezone.update.default', $row->id) }}" class="block">@status($row->default)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
