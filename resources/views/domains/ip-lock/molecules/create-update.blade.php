<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="ip-lock-ip" class="form-label">{{ __('ip-lock-create.ip') }}</label>
        <input type="text" name="ip" class="form-control form-control-lg" id="ip-lock-ip" value="{{ $REQUEST->input('ip') }}" required>
    </div>

    <div class="p-2">
        <label for="ip-lock-end_at" class="form-label">{{ __('ip-lock-create.end_at') }}</label>
        <input type="text" name="end_at" class="form-control form-control-lg" id="ip-lock-end_at" value="{{ $REQUEST->input('end_at') }}">
    </div>
</div>
