@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('role-index.filter') }}" data-table-search="#role-list-table" />
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="alarm-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="w-1">{{ __('role-feature-index.name') }}</th>
                <th class="w-1">{{ __('role-feature-index.description') }}</th>
                <th class="w-1">{{ __('role-feature-index.created') }}</th>
            </tr>
        </thead>
        
        <tbody>
            @foreach ($list as $row)
            <tr>
                <td class="w-1" data-table-sort-value="{{ $row->name }}"><a href="#" class="block">{{ $row->name }}</a></td>
                <td class="w-1" data-table-sort-value="{{ $row->description }}"><a href="#" class="block">{{ $row->description }}</a></td>
                <td class="w-1" data-table-sort-value="{{ $row->created_at }}"><a href="#" class="block"> @dateWithUserTimezone($row->created_at)</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop