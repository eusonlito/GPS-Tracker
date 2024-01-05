<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="configuration-key" class="form-label">{{ __('configuration-create.key') }}</label>
        <input type="text" class="form-control form-control-lg" id="configuration-key" value="{{ $REQUEST->input('key') }}" readonly disabled>
    </div>

    <div class="flex">
        <div class="flex-1 p-2">
            <label for="configuration-value" class="form-label">{{ __('configuration-create.value') }}</label>
            <input type="text" name="value" class="form-control form-control-lg" id="configuration-value" value="{{ $REQUEST->input('value') }}">
        </div>

        <div class="flex-1 p-2">
            <label for="configuration-value_default" class="form-label">{{ __('configuration-create.value_default') }}</label>
            <input type="text" class="form-control form-control-lg" id="configuration-value_default" value="{{ $REQUEST->input('value_default') }}" readonly disabled>
        </div>
    </div>

    <div class="p-2">
        <label for="configuration-description" class="form-label">{{ __('configuration-create.description') }}</label>
        <input type="text" name="description" class="form-control form-control-lg" id="configuration-description" value="{{ $REQUEST->input('description') }}" required>
    </div>
</div>
