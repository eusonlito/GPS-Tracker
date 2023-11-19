@if (config('demo.enabled'))

<div class="demo-header">
    {{ __('demo.header.countdown', ['time' => helper()->demoTimeToReset()]) }}
</div>

@endif
