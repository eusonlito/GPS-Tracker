@extends ('layouts.in')

@section ('body')

@include ('domains.server.log-header')

<form method="get">
    <div class="mt-2 lg:mt-0">
        <input type="search" class="form-control form-control-lg" placeholder="{{ __('server-log.filter') }}" data-table-search="#server-log-table"/>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="server-log-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left">{{ __('server-log.name') }}</th>
                <th>{{ __('server-log.type') }}</th>
                <th>{{ __('server-log.updated_at') }}</th>
                <th>{{ __('server-log.size') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $each)

            @php ($link = route('server.log', ['path' => $each->hash]))

            <tr>
                <td><a href="{{ $link }}" class="block text-left">{{ $each->name }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $each->type }}</a></td>
                <td data-table-sort-value="{{ $each->updated_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($each->updated_at)</a></td>
                <td data-table-sort-value="{{ $each->size }}"><a href="{{ $link }}" class="block">@sizeHuman($each->size)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
