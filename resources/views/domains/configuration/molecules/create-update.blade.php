<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="configuration-key" class="form-label">{{ __('configuration-create.key') }}</label>
        <input type="text" name="key" class="form-control form-control-lg" id="configuration-key" value="{{ $REQUEST->input('key') }}" required>
    </div>

    <div class="p-2">
        <label for="configuration-value" class="form-label">{{ __('configuration-create.value') }}</label>
        <input type="text" name="value" class="form-control form-control-lg" id="configuration-value" value="{{ $REQUEST->input('value') }}" required>
    </div>

    <div class="p-2">
        <label for="configuration-description" class="form-label">{{ __('configuration-create.description') }}</label>
        <input type="text" name="description" class="form-control form-control-lg" id="configuration-description" value="{{ $REQUEST->input('description') }}" required>
    </div>
</div>
