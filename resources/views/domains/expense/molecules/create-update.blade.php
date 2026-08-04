@php ($readonly = !empty($readonly))

<div class="box p-5 mt-5">
    <div class="lg:flex">
        <div class="flex-1 p-2">
            <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" id="expense-create-vehicle" :label="__('expense-create.vehicle')" :readonly="$readonly" :disabled="$readonly" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <x-select name="expense_category_id" :options="$categories" value="id" text="name" id="expense-create-category" :label="__('expense-create.category')" :readonly="$readonly" :disabled="$readonly" required></x-select>
        </div>

        <div class="flex-1 p-2">
            <label for="expense-date_at" class="form-label">{{ __('expense-create.date_at') }}</label>
            <input type="text" name="date_at" class="form-control form-control-lg" id="expense-date_at" value="{{ $REQUEST->input('date_at') }}" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" data-current-date @if ($readonly) readonly disabled @endif required>
        </div>
    </div>

    <div class="lg:flex">
        <div class="flex-1 p-2">
            <label for="expense-name" class="form-label">{{ __('expense-create.name') }}</label>
            <input type="text" name="name" class="form-control form-control-lg" id="expense-name" value="{{ $REQUEST->input('name') }}" @if ($readonly) readonly disabled @endif required>
        </div>

        <div class="flex-1 p-2">
            <label for="expense-amount" class="form-label">{{ __('expense-create.amount') }}</label>
            <input type="number" name="amount" class="form-control form-control-lg" id="expense-amount" value="{{ $REQUEST->input('amount') }}" min="0" step="any" @if ($readonly) readonly disabled @endif required>
        </div>

        <div class="flex-1 p-2">
            <label for="expense-distance" class="form-label">{{ __('expense-create.distance') }}</label>
            <input type="number" name="distance" class="form-control form-control-lg" id="expense-distance" value="{{ $REQUEST->input('distance') }}" min="0" step="any" @if ($readonly) readonly disabled @endif>
        </div>
    </div>

    <div class="p-2">
        <label for="expense-description" class="form-label">{{ __('expense-create.description') }}</label>
        <textarea name="description" class="form-control form-control-lg" id="expense-description" rows="5" @if ($readonly) readonly disabled @endif>{{ $REQUEST->input('description') }}</textarea>
    </div>
</div>

@if ($readonly === false)

@include ('domains.file.molecules.create-update', ['list' => $files])

@endif
