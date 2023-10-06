@include ('domains.shared.index.molecules.map-filters')

<x-map
    :trip="$trip"
    :positions="$positions"
    :data-map-show-last="$trip->finished()"
    :data-map-positions-url="route('shared.trip', $trip->code)"
></x-map>
