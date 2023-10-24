<div id="delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <form action="{{ $route ?? '' }}" method="post">
                    <input type="hidden" name="_action" value="{{ $action ?? 'delete' }}" />

                    <div class="p-5 text-center">
                        @icon('x-circle', 'w-16 h-16 text-theme-24 mx-auto mt-3')

                        <div class="text-3xl mt-5">{{ $title ?? __('delete-modal.title') }}</div>
                        <div class="text-gray-600 mt-2">{!! $message ?? __('delete-modal.message') !!}</div>
                    </div>

                    <div class="px-5 pb-8 text-center">
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">{{ __('delete-modal.cancel') }}</button>
                        <button type="submit" class="btn btn-danger w-24">{{ __('delete-modal.delete') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
