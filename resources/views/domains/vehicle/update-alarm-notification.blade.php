@extends ('domains.vehicle.update-layout')

@section ('content')

<input type="search" class="form-control form-control-lg mt-5" placeholder="{{ __('vehicle-update-alarm-notification.filter') }}" data-table-search="#alarm-notification-list-table" />

<div class="overflow-auto scroll-visible header-sticky">
    <table id="alarm-notification-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left w-1">{{ __('vehicle-update-alarm-notification.alarm') }}</th>
                <th class="text-left w-1">{{ __('vehicle-update-alarm-notification.name') }}</th>
                <th class="text-left">{{ __('vehicle-update-alarm-notification.message') }}</th>
                <th class="text-left">{{ __('vehicle-update-alarm-notification.trip') }}</th>
                <th class="w-1">{{ __('vehicle-update-alarm-notification.created_at') }}</th>
                <th class="w-1">{{ __('vehicle-update-alarm-notification.telegram') }}</th>
                <th class="w-1">{{ __('vehicle-update-alarm-notification.closed_at') }}</th>
                <th class="w-1">{{ __('vehicle-update-alarm-notification.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($notifications as $each)

            <tr>
                <td class="text-left w-1">
                    @if ($each->alarm)
                    <a href="{{ route('alarm.update', $each->alarm->id) }}" class="block">{{ $each->typeFormat()->title() }}</a>
                    @else
                    {{ $each->typeFormat()->title() }}
                    @endif
                </td>
                <td class="text-left w-1"><span class="d-t-m-o max-w-15" title="{{ $each->name }}">{{ $each->name }}</span></td>
                <td class="text-left"><span class="d-t-m-o max-w-15" title="{{ $each->typeFormat()->message() }}">{{ $each->typeFormat()->message() }}</span></td>
                <td class="text-left">
                    @if ($each->trip)
                    <a href="{{ route('trip.update.alarm-notification', $each->trip->id) }}#position-id-{{ $each->position?->id }}" title="{{ $each->trip->name }}" class="d-t-m-o max-w-15">{{ $each->trip->name }}</a>
                    @endif
                </td>
                <td class="w-1">@dateLocal($each->date_at)</td>
                <td class="w-1">@status($each->telegram)</td>
                <td class="w-1">
                    @if ($each->closed_at)
                    @status(true)
                    @else
                    <a href="{{ route('alarm-notification.update.closed-at', $each->id) }}" class="block">@status(false)</a>
                    @endif
                </td>
                <td class="w-1">
                    <a href="{{ route('alarm-notification.delete', $each->id) }}" data-toggle="modal" data-target="#delete-modal" data-delete-modal-one class="text-danger">
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
