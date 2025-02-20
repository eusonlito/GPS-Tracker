@extends ('layouts.in')

@section ('body')

<!-- Hiển thị thông báo thành công nếu có -->
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <!-- Ô tìm kiếm -->
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('permissions-index.filter') }}"
                data-table-search="#permissions-list-table" />
        </div>

        <!-- Chọn user -->
        @if ($users_multiple)
            <div class="flex-grow mt-2 lg:mt-0">
                <x-select name="user_id" :options="$users" value="id" text="name"
                    placeholder="{{ __('permissions-index.user') }}" data-change-submit>
                </x-select>
            </div>
        @endif

        <!-- Chọn vehicle -->
        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name"
                placeholder="{{ __('permissions-index.vehicle') }}" data-change-submit>
            </x-select>
        </div>

        <!-- Bật thông báo -->
        <button type="button" class="sm:ml-4 mt-2 sm:mt-0 bg-white btn form-control-lg" data-notification-request
            data-notification-request-granted="{{ __('permissions-index.notifications-granted') }}"
            data-notification-request-denied="{{ __('permissions-index.notifications-denied') }}">
            {{ __('permissions-index.notifications-enable') }}
        </button>

        <!-- Nút tạo mới permission -->
        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('permissions.create') }}" class="btn form-control-lg whitespace-nowrap">
                {{ __('permissions-index.create') }}
            </a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="permissions-list-table"
        class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort
        data-table-pagination data-table-pagination-limit="10">

        <thead>
            <tr>
                @if ($user_empty)
                    <th>{{ __('permissions-index.user') }}</th>
                @endif

                <th class="w-1">{{ __('ID') }}</th>
                <!-- <th class="w-1">{{ __('Action') }}</th>
                <th class="w-1">{{ __('Entity') }}</th>
                <th class="w-1">{{ __('Scope') }}</th>
                <th class="w-1">{{ __('Created At') }}</th>
                <th class="w-1">{{ __('Actions') }}</th> -->
            </tr>
        </thead>

        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    @if ($user_empty)
                        <td><a href="{{ route('permissions.edit', $permission->id) }}"
                                class="block">{{ $permission->user->name ?? '-' }}</a></td>
                    @endif

                    <td class="w-1">{{ $permission->id }}</td>
                    <!-- <td class="w-1">{{ $permission->action->name ?? '-' }}</td>
                                    <td class="w-1">{{ $permission->entity->name ?? '-' }}</td>
                                    <td class="w-1">{{ $permission->scope->name ?? '-' }}</td>
                                    <td class="w-1" data-table-sort-value="{{ $permission->created_at }}">
                                        @dateWithUserTimezone($permission->created_at)
                                    </td>
                                    <td class="w-1">
                                        @can('edit', $permission)
                                            <a href="{{ route('permissions.edit', $permission->id) }}" class="text-blue-500 hover:underline">
                                                {{ __('Edit') }}
                                            </a> |
                                        @endcan

                                        @can('delete', $permission)
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" id="delete-btn-{{ $permission->id }}" class="text-red-500 hover:underline"
                                                    onclick="return confirm('{{ __('Are you sure?') }}')">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @endcan
                                    </td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop