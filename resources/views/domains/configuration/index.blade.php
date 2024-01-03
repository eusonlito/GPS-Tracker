@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('configuration-index.filter') }}" data-table-search="#configuration-list-table" />
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="configuration-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="text-left w-1">{{ __('configuration-index.key') }}</th>
                <th>{{ __('configuration-index.value') }}</th>
                <th class="text-left">{{ __('configuration-index.description') }}</th>
                <th>{{ __('configuration-index.created_at') }}</th>
                <th>{{ __('configuration-index.updated_at') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('configuration.update', $row->id))

            <tr>
                <td class="text-left w-1"><a href="{{ $link }}" class="block">{{ $row->key }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->value }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="d-t-m-o">{{ $row->description }}</a></td>
                <td data-table-sort-value="{{ $row->created_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->created_at)</a></td>
                <td data-table-sort-value="{{ $row->updated_at }}"><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->updated_at)</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
