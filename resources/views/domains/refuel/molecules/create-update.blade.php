<div class="box p-5 mt-5">
    <div class="lg:flex">
        <div class="flex-1 p-2">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" id="refuel-create-vehicle" :label="__('refuel-create.vehicle')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <label for="refuel-date_at" class="form-label">{{ __('refuel-create.date_at') }}</label>
            <input type="text" name="date_at" class="form-control form-control-lg" id="refuel-date_at" value="{{ $REQUEST->input('date_at') }}" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}" data-current-datetime required>
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <label for="refuel-distance_total" class="form-label">{{ __('refuel-create.distance_total') }}</label>
            <input type="number" name="distance_total" class="form-control form-control-lg" id="refuel-distance_total" value="{{ $REQUEST->input('distance_total') }}" min="0" step="any" required>
        </div>

        <div class="flex-1 p-2">
            <label for="refuel-distance" class="form-label">{{ __('refuel-create.distance') }}</label>
            <input type="number" name="distance" class="form-control form-control-lg" id="refuel-distance" value="{{ $REQUEST->input('distance') }}" min="0" step="any" required data-calculator-difference="#refuel-distance_total">
        </div>

        <div class="flex-1 p-2">
            <label for="refuel-quantity_before" class="form-label">{{ __('refuel-create.quantity_before') }}</label>
            <input type="number" name="quantity_before" class="form-control form-control-lg" id="refuel-quantity_before" value="{{ $REQUEST->input('quantity_before') }}" min="0">
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <label for="refuel-quantity" class="form-label">{{ __('refuel-create.quantity') }}</label>
            <input type="number" name="quantity" class="form-control form-control-lg" id="refuel-quantity" value="{{ $REQUEST->input('quantity') }}" min="0" step="any" required>
        </div>

        <div class="flex-1 p-2">
            <label for="refuel-price" class="form-label">{{ __('refuel-create.price') }}</label>
            <input type="number" name="price" class="form-control form-control-lg" id="refuel-price" value="{{ $REQUEST->input('price') }}" min="0" step="any" required>
        </div>

        <div class="flex-1 p-2">
            <label for="refuel-total" class="form-label">{{ __('refuel-create.total') }}</label>
            <input type="number" name="total" class="form-control form-control-lg" id="refuel-total" value="{{ $REQUEST->input('total') }}" min="0" step="any" required data-calculator-total data-calculator-total-first="#refuel-quantity" data-calculator-total-second="#refuel-price">
        </div>
    </div>

    <div class="md:flex">
        <div class="flex-1 p-2">
            <label for="refuel-latitude" class="form-label">{{ __('refuel-update.latitude') }}</label>
            <input type="number" name="latitude" class="form-control form-control-lg" id="refuel-latitude" value="{{ $REQUEST->input('latitude') }}" step="any" required>
        </div>

        <div class="flex-1 p-2">
            <label for="refuel-longitude" class="form-label">{{ __('refuel-update.longitude') }}</label>
            <input type="number" name="longitude" class="form-control form-control-lg" id="refuel-longitude" value="{{ $REQUEST->input('longitude') }}" step="any" required>
        </div>
    </div>

    <div class="map-point mt-5" data-map-point data-map-point-latitude="#refuel-latitude" data-map-point-longitude="#refuel-longitude" data-map-point-zoom="18"></div>
</div>
