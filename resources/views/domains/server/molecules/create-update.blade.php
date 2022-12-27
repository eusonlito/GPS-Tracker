<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="server-port" class="form-label">{{ __('server-create.port') }}</label>
        <input type="number" name="port" class="form-control form-control-lg" id="server-port" value="{{ $REQUEST->input('port') }}" min="0" step="1">
    </div>

    <div class="p-2">
        <x-select name="protocol" :options="$protocols" id="server-create-protocol" :label="__('server-create.protocol')" :placeholder="__('server-create.protocol-select')" value-only required></x-select>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="debug" value="1" class="form-check-switch" id="server-debug" {{ $REQUEST->input('debug') ? 'checked' : '' }}>
            <label for="server-debug" class="form-check-label">{{ __('server-create.debug') }}</label>
        </div>
    </div>

    <div class="p-2">
        <div class="form-check">
            <input type="checkbox" name="enabled" value="1" class="form-check-switch" id="server-enabled" {{ $REQUEST->input('enabled') ? 'checked' : '' }}>
            <label for="server-enabled" class="form-check-label">{{ __('server-create.enabled') }}</label>
        </div>
    </div>
</div>
