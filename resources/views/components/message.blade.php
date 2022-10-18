<app-message {{ $attributes->merge(['class' => $class]) }}>
    @icon('alert-circle', 'w-6 h-6 mr-2')

    {!! $message !!}

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('common.close') }}">
        @icon('x', 'w-4 h-4')
    </button>
</app-message>
