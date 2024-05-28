@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('monitor.queue', 'pending') }}" class="p-4 {{ ($name === 'pending') ? 'active' : '' }}" role="tab">{{ __('monitor-queue.header.pending') }}</a>
        <a href="{{ route('monitor.queue', 'delayed') }}" class="p-4 {{ ($name === 'delayed') ? 'active' : '' }}" role="tab">{{ __('monitor-queue.header.delayed') }}</a>
        <a href="{{ route('monitor.queue', 'failed') }}" class="p-4 {{ ($name === 'failed') ? 'active' : '' }}" role="tab">{{ __('monitor-queue.header.failed') }}</a>
    </div>
</div>

<div class="tab-content mt-5">
    <div class="tab-pane active" role="tabpanel">
        <div class="box p-5">
            @yield('content')
        </div>
    </div>
</div>

@stop
