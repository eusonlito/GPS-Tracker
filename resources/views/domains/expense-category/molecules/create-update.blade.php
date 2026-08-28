<div class="box p-5 mt-5">
    <div class="p-2">
        <label for="expense-category-name" class="form-label">{{ __('expense-category-create.name') }}</label>
        <input type="text" name="name" class="form-control form-control-lg" id="expense-category-name" value="{{ $REQUEST->input('name') }}" required>
    </div>

    @if ($AUTH->admin)

    <div class="p-2">
        <div class="form-check">
            @if ($system ?? false)
            <input type="hidden" name="global" value="1" />
            <input type="checkbox" value="1" class="form-check-switch" id="expense-category-global" checked disabled>
            @else
            <input type="checkbox" name="global" value="1" class="form-check-switch" id="expense-category-global" {{ $REQUEST->input('global') ? 'checked' : '' }}>
            @endif
            <label for="expense-category-global" class="form-check-label">{{ __('expense-category-create.global') }}</label>
        </div>
    </div>

    @endif
</div>
