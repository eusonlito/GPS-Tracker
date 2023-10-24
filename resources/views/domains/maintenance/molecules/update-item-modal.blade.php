<div id="update-item-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ route('maintenance-item.create') }}" method="post">
                    <input type="hidden" name="_action" value="updateItemCreate" />

                    <div class="p-5 text-center">
                        <label for="maintenance-item-name" class="form-label">{{ __('maintenance-update-item-modal.name') }}</label>
                        <input type="text" name="name" class="form-control form-control-lg" id="maintenance-item-name" required>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('maintenance-update-item-modal.cancel') }}</button>
                        <button type="submit" class="btn btn-primary w-24">{{ __('maintenance-update-item-modal.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
