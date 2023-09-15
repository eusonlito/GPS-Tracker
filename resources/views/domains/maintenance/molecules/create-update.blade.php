<div class="box p-5 mt-5">
    <div class="lg:flex">
        <div class="flex-1 p-2">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" id="maintenance-create-vehicle" :label="__('maintenance-create.vehicle')" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <label for="maintenance-date_at" class="form-label">{{ __('maintenance-create.date_at') }}</label>
            <input type="text" name="date_at" class="form-control form-control-lg" id="maintenance-date_at" value="{{ $REQUEST->input('date_at') }}" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" data-current-date required>
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <label for="maintenance-name" class="form-label">{{ __('maintenance-create.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="maintenance-name" value="{{ $REQUEST->input('name') }}" required>
        </div>

        <div class="flex-1 p-2">
            <label for="maintenance-workshop" class="form-label">{{ __('maintenance-create.workshop') }}</label>
            <input type="text" name="workshop" class="form-control form-control-lg" id="maintenance-workshop" value="{{ $REQUEST->input('workshop') }}" required>
        </div>

        <div class="flex-1 p-2">
            <label for="maintenance-amount" class="form-label">{{ __('maintenance-create.amount') }}</label>
            <input type="number" name="amount" class="form-control form-control-lg" id="maintenance-amount" value="{{ $REQUEST->input('amount') }}" min="0" step="any">
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <label for="maintenance-distance" class="form-label">{{ __('maintenance-create.distance') }}</label>
            <input type="number" name="distance" class="form-control form-control-lg" id="maintenance-distance" value="{{ $REQUEST->input('distance') }}" min="0" step="any">
        </div>

        <div class="flex-1 p-2">
            <label for="maintenance-distance_next" class="form-label">{{ __('maintenance-create.distance_next') }}</label>
            <input type="number" name="distance_next" class="form-control form-control-lg" id="maintenance-distance_next" value="{{ $REQUEST->input('distance_next') }}" min="0" step="any">
        </div>
    </div>

    <div class="p-2">
        <label for="maintenance-description" class="form-label">{{ __('maintenance-create.description') }}</label>
        <textarea name="description" class="form-control form-control-lg" id="maintenance-description" rows="5">{{ $REQUEST->input('description') }}</textarea>
    </div>
</div>

@include ('domains.file.molecules.create-update', ['list' => $files])
