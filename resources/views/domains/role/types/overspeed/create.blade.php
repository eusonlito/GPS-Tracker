<div class="box p-5 mt-5 md:flex">
    <div class="flex-1 p-2">
        <label for="alarm-type-overspeed-speed" class="form-label">{{ __('alarm-type-overspeed.speed') }}</label>
        <input type="number" name="config[speed]" class="form-control form-control-lg" id="alarm-type-overspeed-speed" value="{{ $REQUEST->input('config.speed') }}" step="1" required>
    </div>
</div>
