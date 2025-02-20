@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>{{ __('Quản lý vai trò') }}</h3>
        </div>

        <div class="card-body">
            <!-- Form tìm kiếm -->
            <form method="GET" action="{{ route('role.index') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text"
                            name="search"
                            class="form-control"
                            placeholder="Tìm kiếm..."
                            value="{{ $search }}">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary" type="submit">
                            {{ __('Tìm kiếm') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Bảng dữ liệu -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __('Tên') }}</th>
                            <th>{{ __('Mô tả') }}</th>
                            <th>{{ __('Ngày tạo') }}</th>
                            <th>{{ __('Thao tác') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->description }}</td>
                            <td>{{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y H:i') }}</td>
                            <!-- <td>
                                <!-- <a href="{{ route('role.edit', $role->id) }}"
                                    class="btn btn-sm btn-primary">
                                    {{ __('Sửa') }}
                                </a> -->
                            </td> -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                {{ __('Không có dữ liệu') }}
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            {{ $roles->links() }}
        </div>
    </div>
</div>
@endsection