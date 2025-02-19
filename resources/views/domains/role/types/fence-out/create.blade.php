<div class="box p-5 mt-5 md:flex">
    <div class="flex-1 p-2">
        <label for="alarm-type-fence-out-latitude" class="form-label">{{ __('alarm-type-fence-out.latitude') }}</label>
        <input type="number" name="config[latitude]" class="form-control form-control-lg" id="alarm-type-fence-out-latitude" value="{{ $REQUEST->input('config.latitude') ?: $position?->latitude }}" step="any" required>
    </div>

    <div class="flex-1 p-2">
        <label for="alarm-type-fence-out-longitude" class="form-label">{{ __('alarm-type-fence-out.longitude') }}</label>
        <input type="number" name="config[longitude]" class="form-control form-control-lg" id="alarm-type-fence-out-longitude" value="{{ $REQUEST->input('config.longitude') ?: $position?->longitude }}" step="any" required>
    </div>

    <div class="flex-1 p-2">
        <label for="alarm-type-fence-out-radius" class="form-label">{{ __('alarm-type-fence-out.radius') }}</label>
        <input type="number" name="config[radius]" class="form-control form-control-lg" id="alarm-type-fence-out-radius" value="{{ $REQUEST->input('config.radius') ?: 5 }}" step="0.1" required>
    </div>
</div>

<div class="map-fence mt-5" data-map-fence data-map-fence-latitude="#alarm-type-fence-out-latitude" data-map-fence-longitude="#alarm-type-fence-out-longitude" data-map-fence-radius="#alarm-type-fence-out-radius"></div>
