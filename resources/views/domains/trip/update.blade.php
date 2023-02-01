@extends ('domains.trip.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="trip-name" class="form-label">{{ __('trip-update.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="trip-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="p-2">
            <div class="form-check">
                <input type="checkbox" name="shared" value="1" class="form-check-switch" id="trip-shared" {{ $REQUEST->input('shared') ? 'checked' : '' }}>
                <label for="trip-shared" class="form-check-label">{{ __('trip-update.shared') }}</label>
            </div>
        </div>
    </div>

    @if ($row->shared)

    <div class="box p-5 mt-5">
        <div class="p-2">
            <span class="font-medium">{{ __('trip-update.shared-url') }}</span> <a href="{{ route('trip.shared', $row->code) }}" class="text-primary" target="_blank">{{ route('trip.shared', $row->code) }}</a>
        </div>
    </div>

    @endif

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('trip-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('trip-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal')

@stop
