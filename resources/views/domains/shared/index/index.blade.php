@extends ('layouts.shared')

@section ('body')

<div class="my-5">
    @if ($devices->isEmpty())

    @include ('domains.shared.index.molecules.devices-empty')

    @elseif ($device && $trips->isEmpty())

    @include ('domains.shared.index.molecules.trips-empty')

    @elseif ($trip)

    @include ('domains.shared.index.molecules.trips-map')

    @else

    @include ('domains.shared.index.molecules.devices-map')

    @endif
</div>

@stop
