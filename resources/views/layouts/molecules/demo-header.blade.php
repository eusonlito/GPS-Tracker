@if (config('demo.enabled'))

<div class="demo-header">
    {{ __('demo.header.countdown', ['time' => helper()->dateDiffHuman(time(), date('Y-m-d '.config('demo.reset_time'), strtotime('tomorrow')))]) }}
    - <a href="https://github.com/eusonlito/GPS-Tracker" target="_blank">GitHub</a>
</div>

@endif
