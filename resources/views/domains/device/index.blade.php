@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('device-index.filter') }}" data-table-search="#device-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('device.create') }}" class="btn form-control-lg">{{ __('device-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="device-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="text-center">{{ __('device-index.name') }}</th>
                <th class="text-center">{{ __('device-index.maker') }}</th>
                <th class="text-center">{{ __('device-index.serial') }}</th>
                <th class="text-center">{{ __('device-index.port') }}</th>
                <th class="text-center">{{ __('device-index.timezone') }}</th>
                <th>{{ __('device-index.enabled') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('device.update', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->maker }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->serial }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->port }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->timezone->zone }}</a></td>
                <td data-table-sort-value="{{ (int)$row->enabled }}">@status($row->enabled)</td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-2 p-2 text-right">
    <a href="{{ route('device.create') }}" class="btn form-control-lg bg-white">{{ __('device-index.create') }}</a>
</div>

@stop
