@extends('layouts.in')

@section('body')
<!-- Search Form -->
<form method="GET" action="{{ route('role.index') }}" class="sm:flex sm:space-x-4">
    <div class="flex-grow mt-2 sm:mt-0">
        <input type="search"
            name="search"
            class="form-control form-control-lg"
            placeholder="{{ __('role-index.Search...') }}"
            value="{{ $search }}"
            data-table-search="#role-list-table">
    </div>

    <div class="sm:ml-4 mt-2 sm:mt-0">
        <button type="submit" class="btn form-control-lg bg-white">
            {{ __('role-index.Search') }}
        </button>
    </div>
</form>

<!-- Data Table -->
<div class="overflow-auto scroll-visible header-sticky mt-4">
    <table id="role-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="w-1">{{ __('role-index.ID') }}</th>
                <th class="text-left w-1">{{ __('role-index.Name') }}</th>
                <th class="text-left w-1">{{ __('role-index.Description') }}</th>
                <th class="w-1">{{ __('role-index.Created At') }}</th>
                <th class="w-1">{{ __('role-index.Actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @forelse($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td class="text-left">{{ $role->name }}</td>
                <td class="text-left">{{ $role->description }}</td>
                <td data-table-sort-value="{{ $role->created_at }}">
                    {{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y H:i') }}
                </td>
                <td>
                    <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary btn-sm">
                        {{ __('role-index.Edit') }}
                    </a>
                    <form action="{{ route('role.destroy', $role->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('{{ __('role-delete.confirm') }}');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            {{ __('role-index.Delete') }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">
                    {{ __('role-index.No data available') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $roles->links('pagination::bootstrap-4') }}
</div>
@endsection