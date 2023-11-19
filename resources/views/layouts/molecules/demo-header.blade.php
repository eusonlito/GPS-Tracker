@if (config('demo.enabled'))

<div class="demo-header">
    {{ __('demo.header.countdown', ['time' => helper()->demoTimeToReset()]) }}.
    <a href="https://github.com/eusonlito/GPS-Tracker" target="_blank">View at Github</a>.
</div>

@endif
