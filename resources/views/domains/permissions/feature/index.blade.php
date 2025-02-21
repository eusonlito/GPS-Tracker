@extends ('layouts.in')

@section ('body')

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
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="permissions-list-table"
        class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort
        data-table-pagination data-table-pagination-limit="10">
    </table>
</div>

@stop