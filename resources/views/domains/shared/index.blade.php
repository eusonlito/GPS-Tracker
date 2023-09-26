@extends ('layouts.empty')

@section ('body')

<div class="my-5">
    <div class="overflow-auto lg:overflow-visible header-sticky">
        <form method="get">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('shared-index.device-filter') }}" data-table-search="#shared-devices-table" />
        </form>

        <table id="shared-devices-table" class="table table-report font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
            <thead>
                <tr>
                    <th class="text-left">{{ __('shared-index.device-name') }}</th>
                    <th class="text-left">{{ __('shared-index.trip-name') }}</th>
                    <th>{{ __('shared-index.trip-start_at') }}</th>
                    <th>{{ __('shared-index.trip-end_at') }}</th>
                    <th>{{ __('shared-index.trip-distance') }}</th>
                    <th>{{ __('shared-index.trip-time') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($devices as $device)

                @php ($link = route('device.shared', $device->code))

                <tr>
                    <td class="text-left"><a href="{{ $link }}" class="d-t-m-o max-w-md" title="{{ $device->name }}">{{ $device->name }}</a></td>

                    @if ($trip = $device->tripLastShared)

                    <td class="text-left"><a href="{{ $link }}" class="d-t-m-o max-w-md" title="{{ $trip->name }}">{{ $trip->name }}</a></td>

                    <td><a href="{{ $link }}" class="block">{{ $trip->start_at }}</a></td>
                    <td><a href="{{ $link }}" class="block">{{ $trip->end_at }}</a></td>
                    <td data-table-sort-value="{{ $trip->distance }}"><a href="{{ $link }}" class="block">@unitHuman('distance', $trip->distance)</a></td>
                    <td data-table-sort-value="{{ $trip->time }}"><a href="{{ $link }}" class="block">@timeHuman($trip->time)</a></td>

                    @else

                    <td colspan="5"></td>

                    @endif
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@stop
