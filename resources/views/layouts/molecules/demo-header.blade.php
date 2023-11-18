@if (config('demo.enabled'))

<div class="demo-header">
    {{ __('demo.header.countdown', ['time' => helper()->dateDiffHuman(time(), strtotime('tomorrow '.config('demo.reset_time')))]) }}
</div>

@endif
