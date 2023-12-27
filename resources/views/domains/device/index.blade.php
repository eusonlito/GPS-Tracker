@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('device-index.filter') }}" data-table-search="#device-list-table" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('device-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('device-index.vehicle') }}" data-change-submit></x-select>
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('device.map') }}" class="btn form-control-lg whitespace-nowrap">{{ __('device-index.map') }}</a>
        </div>

        <div class="sm:ml-4 mt-2 sm:mt-0 bg-white">
            <a href="{{ route('device.create') }}" class="btn form-control-lg whitespace-nowrap">{{ __('device-index.create') }}</a>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="device-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th>{{ __('device-index.name') }}</th>
                <th>{{ __('device-index.model') }}</th>

                @if ($user_empty)
                <th>{{ __('device-index.user') }}</th>
                @endif

                @if ($vehicle_empty)
                <th>{{ __('device-index.vehicle') }}</th>
                @endif

                <th>{{ __('device-index.connected_at') }}</th>
                <th>{{ __('device-index.enabled') }}</th>
                <th>{{ __('device-index.shared') }}</th>
                <th>{{ __('device-index.shared_public') }}</th>
                <th>{{ __('trip-index.messages') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('device.update', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $row->model }}</a></td>

                @if ($user_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->user->name }}</a></td>
                @endif

                @if ($vehicle_empty)
                <td><a href="{{ $link }}" class="block">{{ $row->vehicle->name ?? '-' }}</a></td>
                @endif

                <td><a href="{{ $link }}" class="block">@dateWithUserTimezone($row->connected_at, 'Y-m-d H:i:s')</a></td>
                <td data-table-sort-value="{{ (int)$row->enabled }}" class="w-1">@status($row->enabled)</td>
                <td data-table-sort-value="{{ (int)$row->shared }}" class="w-1"><a href="{{ route('device.update.boolean', [$row->id, 'shared']) }}" class="block" data-update-boolean="shared">@status($row->shared)</a></td>
                <td data-table-sort-value="{{ (int)$row->shared_public }}" class="w-1"><a href="{{ route('device.update.boolean', [$row->id, 'shared_public']) }}" class="block" data-update-boolean="shared_public">@status($row->shared_public)</a></td>
                <td class="w-1">
                    <a href="{{ route('device.update.device-message', $row->id) }}" class="{{ $row->messages_pending_count ? 'text-warning' : 'text-success' }}">
                        {{ $row->messages_count.($row->messages_pending_count ? ('/'.$row->messages_pending_count) : '') }}
                    </a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@stop
