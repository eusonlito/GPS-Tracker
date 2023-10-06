<form method="GET">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-1 mb-2">
            <x-select name="device_code" :options="$devices" value="code" text="name" :placeholder="__('shared-index.choose-device')" data-change-submit></x-select>
        </div>

        @if ($trips->isNotEmpty())

        <div class="flex-1 mb-4">
            <div class="flex">
                <div class="flex-1">
                    <x-select name="trip_code" :options="$trips" value="code" text="name" data-change-submit></x-select>
                </div>

                @if ($trip_previous_code)
                <a href="?@query(['trip_code' => $trip_previous_code])" class="btn bg-white ml-2">@icon('chevrons-left', 'w-4 h-4')</a>
                @else
                <span class="btn bg-white ml-2 text-gray-300 cursor-default">@icon('chevrons-left', 'w-4 h-4')</span>
                @endif

                @if ($trip_next_code)
                <a href="?@query(['trip_code' => $trip_next_code])" class="btn bg-white ml-2">@icon('chevrons-right', 'w-4 h-4')</a>
                @else
                <span class="btn bg-white ml-2 text-gray-300 cursor-default">@icon('chevrons-right', 'w-4 h-4')</span>
                @endif
            </div>
        </div>

        <div class="mb-4 text-center">
            <a href="#" class="btn bg-white mr-2" data-map-live>@icon('play', 'w-4 h-4 sm:w-6 sm:h-6')</a>
        </div>

        @endif
    </div>
</form>
