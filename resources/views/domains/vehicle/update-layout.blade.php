@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('vehicle.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'vehicle.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
        <a href="{{ route('vehicle.update.device', $row->id) }}" class="p-4 {{ ($ROUTE === 'vehicle.update.device') ? 'active' : '' }}" role="tab">{{ __('vehicle-update.devices') }}</a>
        <a href="{{ route('vehicle.update.alarm', $row->id) }}" class="p-4 {{ ($ROUTE === 'vehicle.update.alarm') ? 'active' : '' }}" role="tab">{{ __('vehicle-update.alarms') }}</a>
        <a href="{{ route('vehicle.update.alarm-notification', $row->id) }}" class="p-4 {{ ($ROUTE === 'vehicle.update.alarm-notification') ? 'active' : '' }}" role="tab">{{ __('vehicle-update.notifications') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
