@extends('layouts.in')

@section('body')
<!-- Form tìm kiếm -->
<form method="GET" action="{{ route('role.index') }}" class="sm:flex sm:space-x-4">
    <div class="flex-grow mt-2 sm:mt-0">
        <input type="search"
            name="search"
            class="form-control form-control-lg"
            placeholder="Tìm kiếm..."
            value="{{ $search }}"
            data-table-search="#role-list-table">
    </div>

    <div class="sm:ml-4 mt-2 sm:mt-0">
        <button type="submit" class="btn form-control-lg bg-white">
            {{ __('Tìm kiếm') }}
        </button>
    </div>
</form>

<!-- Bảng dữ liệu -->
<div class="overflow-auto scroll-visible header-sticky mt-4">
    <table id="role-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="w-1">{{ __('ID') }}</th>
                <th class="text-left w-1">{{ __('Tên') }}</th>
                <th class="text-left w-1">{{ __('Mô tả') }}</th>
                <th class="w-1">{{ __('Ngày tạo') }}</th>
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
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">
                    {{ __('Không có dữ liệu') }}
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Phân trang -->
<div class="mt-4">
    {{ $roles->links('pagination::bootstrap-4') }}
</div>

@endsection