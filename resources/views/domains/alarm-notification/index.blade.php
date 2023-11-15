@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="sm:flex sm:space-x-4">
        <div class="flex-grow mt-2 sm:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('alarm-notification-index.filter') }}" data-table-search="#alarm-notification-list-table" />
        </div>

        @if ($users_multiple)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="user_id" :options="$users" value="id" text="name" placeholder="{{ __('alarm-notification-index.user') }}" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" placeholder="{{ __('alarm-notification-index.vehicle') }}" data-change-submit></x-select>
        </div>
    </div>
</form>

<div class="overflow-auto scroll-visible header-sticky">
    <table id="alarm-notification-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                @if ($user_empty)
                <th class="w-1">{{ __('alarm-notification-index.user') }}</th>
                @endif

                @if ($vehicle_empty)
                <th class="w-1">{{ __('alarm-notification-index.vehicle') }}</th>
                @endif

                <th class="text-left w-1">{{ __('alarm-notification-index.alarm') }}</th>
                <th class="text-left w-1">{{ __('alarm-notification-index.name') }}</th>
                <th class="text-left">{{ __('alarm-notification-index.message') }}</th>
                <th class="text-left">{{ __('alarm-notification-index.trip') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.created_at') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.telegram') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.closed_at') }}</th>
                <th class="w-1">{{ __('alarm-notification-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            <tr>
                @if ($user_empty)
                <td><span class="block">{{ $row->user->name }}</span></td>
                @endif

                @if ($vehicle_empty)
                <td class="w-1"><a href="{{ route('vehicle.update', $row->vehicle->id) }}" class="block">{{ $row->vehicle->name }}</a></td>
                @endif

                <td class="text-left w-1">
                    @if ($row->alarm)
                    <a href="{{ route('alarm.update', $row->alarm->id) }}" class="block">{{ $row->typeFormat()->title() }}</a>
                    @else
                    {{ $row->typeFormat()->title() }}
                    @endif
                </td>
                <td class="text-left w-1"><span class="d-t-m-o max-w-15" title="{{ $row->name }}">{{ $row->name }}</span></td>
                <td class="text-left"><span class="d-t-m-o max-w-15" title="{{ $row->typeFormat()->message() }}">{{ $row->typeFormat()->message() }}</span></td>
                <td class="text-left">
                    @if ($row->trip)
                    <a href="{{ route('trip.update.alarm-notification', $row->trip->id) }}#position-id-{{ $row->position?->id }}" title="{{ $row->trip->name }}" class="d-t-m-o max-w-15">{{ $row->trip->name }}</a>
                    @endif
                </td>
                <td class="w-1">@dateLocal($row->date_at)</td>
                <td class="w-1">@status($row->telegram)</td>
                <td class="w-1">
                    @if ($row->closed_at)
                    @status(true)
                    @else
                    <a href="{{ route('alarm-notification.update.closed-at', $row->id) }}" class="block">@status(false)</a>
                    @endif
                </td>
                <td class="w-1">
                    <a href="{{ route('alarm-notification.delete', $row->id) }}" data-toggle="modal" data-target="#delete-modal" data-delete-modal-one class="text-danger">
                        @icon('trash', 'w-4 h-4')
                    </a>
                </td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@include ('molecules.delete-modal', [
    'action' => 'delete'
])

@stop
