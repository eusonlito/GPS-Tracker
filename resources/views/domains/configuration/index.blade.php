@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('configuration-index.filter') }}" data-table-search="#configuration-list-table" />
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('configuration.create') }}" class="btn form-control-lg">{{ __('configuration-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto md:overflow-visible header-sticky">
    <table id="configuration-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="w-1">{{ __('configuration-index.id') }}</th>
                <th class="text-left">{{ __('configuration-index.key') }}</th>
                <th class="text-center">{{ __('configuration-index.value') }}</th>
                <th class="text-left">{{ __('configuration-index.description') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('configuration.update', $row->id))

            <tr>
                <td class="w-1"><a href="{{ $link }}" class="block text-center font-semibold whitespace-nowrap">{{ $row->id }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap text-left">{{ $row->key }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->value }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold truncate text-left">{{ $row->description }}</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-2 p-2 text-right">
    <a href="{{ route('configuration.create') }}" class="btn form-control-lg bg-white">{{ __('configuration-index.create') }}</a>
</div>

@stop
