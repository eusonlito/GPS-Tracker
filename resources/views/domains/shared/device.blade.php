@extends ('layouts.shared')

@section ('body')

<div class="my-5">
    <h2 class="box px-5 py-2 font-medium text-xl sm:text-2xl">{{ $device->name }}</h2>

    <div class="overflow-auto scroll-visible header-sticky">
        <table id="device-trips-table" class="table table-report font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
            <thead>
                <tr>
                    <th class="text-left">{{ __('shared-device.trip-name') }}</th>
                    <th>{{ __('shared-device.trip-start_at') }}</th>
                    <th>{{ __('shared-device.trip-end_at') }}</th>
                    <th>{{ __('shared-device.trip-distance') }}</th>
                    <th>{{ __('shared-device.trip-time') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($trips as $trip)

                @php ($link = route('shared.trip', $trip->code))

                <tr>
                    <td class="text-left"><a href="{{ $link }}" class="d-t-m-o max-w-md" title="{{ $trip->name }}">{{ $trip->name }}</a></td>

                    <td><a href="{{ $link }}" class="block">{{ $trip->start_at }}</a></td>
                    <td><a href="{{ $link }}" class="block">{{ $trip->end_at }}</a></td>
                    <td data-table-sort-value="{{ $trip->distance }}"><a href="{{ $link }}" class="block">@unitHuman('distance', $trip->distance)</a></td>
                    <td data-table-sort-value="{{ $trip->time }}"><a href="{{ $link }}" class="block">@timeHuman($trip->time)</a></td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
