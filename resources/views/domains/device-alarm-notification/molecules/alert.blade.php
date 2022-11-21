<app-message class="show flex items-center mb-2 mt-2 alert alert-danger">
    <div class="hidden lg:block">
        @icon('alert-circle', 'w-6 h-6 mr-2')
    </div>

    <div class="mr-4">
        <strong>
            <a href="{{ route('device.update', $row->device->id) }}">{{ $row->device->name }}</a>

            <span class="mx-2">-</span>

            <a href="{{ route('device.update.device-alarm.update', [$row->device->id, $row->alarm->id]) }}">
                {{ $row->alarm->name }}
                -
                {{ $row->typeFormat()->title() }}
            </a>

            @if ($row->trip)
            <span class="mx-2">-</span>

            <a href="{{ route('trip.update.map', $row->trip->id) }}#position-id-{{ $row->position?->id }}">{{ $row->trip->name }}</a>
            @endif
        </strong>

        <span class="mx-2">-</span>

        <a href="{{ route('device.update.device-alarm-notification', $row->device->id) }}">{{ $row->typeFormat()->message() }}</a>
    </div>

    <a href="{{ route('device-alarm-notification.update.closed-at', $row->id) }}" class="btn-close">
        @icon('x', 'w-4 h-4')
    </a>
</app-message>
