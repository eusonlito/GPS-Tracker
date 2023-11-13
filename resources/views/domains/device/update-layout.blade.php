@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('device.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'device.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
        <a href="{{ route('device.update.device-message', $row->id) }}" class="p-4 {{ ($ROUTE === 'device.update.device-message') ? 'active' : '' }}" role="tab">{{ __('device-update.messages') }}</a>

        @if ($AUTH->managerMode())
        <a href="{{ route('device.update.transfer', $row->id) }}" class="p-4 {{ ($ROUTE === 'device.update.transfer') ? 'active' : '' }}" role="tab">{{ __('device-update.transfer') }}</a>
        @endif
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
