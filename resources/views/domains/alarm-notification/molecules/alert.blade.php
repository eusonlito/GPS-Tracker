<app-message class="show flex items-center mb-2 mt-2 alert alert-danger">
    <div class="hidden lg:block">
        @icon('alert-circle', 'w-6 h-6 mr-2')
    </div>

    <div class="mr-4">
        <td class="w-1">@dateLocal($row->date_at)</td>

        <span class="mx-2">-</span>

        <strong>
            <a href="{{ route('vehicle.update', $row->vehicle->id) }}">{{ $row->vehicle->name }}</a>

            <span class="mx-2">-</span>

            @if ($row->alarm)

            <a href="{{ route('alarm.update', $row->alarm->id) }}">
                {{ $row->alarm->name }}
                -
                {{ $row->typeFormat()->title() }}
            </a>

            @else

            <span>{{ $row->typeFormat()->title() }}</span>

            @endif

            @if ($row->trip)
            <span class="mx-2">-</span>

            <a href="{{ route('trip.update.alarm-notification', $row->trip->id) }}#position-id-{{ $row->position?->id }}">{{ $row->trip->name }}</a>
            @endif
        </strong>

        <span class="mx-2">-</span>

        <a href="{{ route('vehicle.update.alarm-notification', $row->vehicle->id) }}">{{ $row->typeFormat()->message() }}</a>
    </div>

    <a href="{{ route('alarm-notification.update.closed-at', $row->id) }}" class="btn-close">
        @icon('x', 'w-4 h-4')
    </a>
</app-message>
