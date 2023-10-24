<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="maintenance-item-name" class="form-label">{{ __('maintenance-item-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="maintenance-item-name" value="{{ $REQUEST->input('name') }}" required>
    </div>
</div>
