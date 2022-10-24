@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('user-index.filter') }}" data-table-search="#user-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('user.create') }}" class="btn form-control-lg">{{ __('user-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="user-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-pagination="user-list-table-pagination" data-table-sort>
        <thead>
            <tr>
                <th class="w-1">{{ __('user-index.id') }}</th>
                <th class="text-left">{{ __('user-index.name') }}</th>
                <th class="text-left">{{ __('user-index.email') }}</th>
                <th>{{ __('user-index.admin') }}</th>
                <th>{{ __('user-index.enabled') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('user.update', $row->id))

            <tr>
                <td class="w-1"><a href="{{ $link }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->id }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->name }}</a></td>
                <td class="text-left"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->email }}</a></td>
                <td data-table-sort-value="{{ (int)$row->admin }}">@status($row->admin)</td>
                <td data-table-sort-value="{{ (int)$row->enabled }}">@status($row->enabled)</td>
            </tr>

            @endforeach
        </tbody>
    </table>

    <ul id="user-list-table-pagination" class="pagination justify-end"></ul>
</div>

<div class="box mt-2 p-2 text-right">
    <a href="{{ route('user.create') }}" class="btn form-control-lg">{{ __('user-index.create') }}</a>
</div>

@stop
