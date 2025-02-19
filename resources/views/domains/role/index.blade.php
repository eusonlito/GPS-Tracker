@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('role-index.filter') }}" data-table-search="#role-list-table" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('device-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <button type="button" class="sm:ml-4 mt-2 sm:mt-0 bg-white btn form-control-lg" data-notification-request data-notification-request-granted="{{ __('role-index.notifications-granted') }}" data-notification-request-denied="{{ __('role-index.notifications-denied') }}">{{ __('role-index.notifications-enable') }}</button>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="role-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
    </table>
</div>

@stop