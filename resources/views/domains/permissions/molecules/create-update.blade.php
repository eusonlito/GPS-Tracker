<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="permission-name" class="form-label">{{ __('permission-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="permission-name"
            value="{{ old('name') }}" required>
    </div>

    <div class="p-2">
        <label for="permission-description" class="form-label">{{ __('permission-create.description') }}</label>
        <input type="text" name="description" class="form-control form-control-lg" id="permission-description"
            value="{{ old('description') }}">
    </div>
</div>

<div class="box p-5 mt-5">
    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="assignable" value="1" class="form-check-switch" id="permission-assignable"
                {{ old('assignable') ? 'checked' : '' }}>
            <label for="permission-assignable" class="form-check-label">{{ __('permission-create.assignable') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="permission-enabled"
                {{ old('enabled', 1) ? 'checked' : '' }}>
            <label for="permission-enabled" class="form-check-label">{{ __('permission-create.enabled') }}</label>
        </div>
    </div>
</div>
