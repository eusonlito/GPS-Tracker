@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('expense-category-index.filter') }}" data-table-search="#expense-category-list-table" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('expense-category-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="lg:ml-4 mt-2 lg:mt-0 bg-white">
            <a href="{{ route('expense-category.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('expense-category-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="expense-category-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($user_empty)
                <th>{{ __('expense-category-index.user') }}</th>
                @endif

                <th class="text-left">{{ __('expense-category-index.name') }}</th>
                <th>{{ __('expense-category-index.expenses_count') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('expense-category.update', $row->id))

            <tr>
                @if ($user_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->user?->name ?: __('expense-category-index.global') }}</a></td>
                @endif

                <td><a href="{{ $link }}" class="block text-left">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->expenses_count }}</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
