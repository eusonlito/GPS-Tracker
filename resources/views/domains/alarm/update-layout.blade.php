@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('alarm.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'alarm.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
        <a href="{{ route('alarm.update.vehicle', $row->id) }}" class="p-4 {{ ($ROUTE === 'alarm.update.vehicle') ? 'active' : '' }}" role="tab">{{ __('alarm-update.vehicles') }}</a>
        <a href="{{ route('alarm.update.alarm-notification', $row->id) }}" class="p-4 {{ ($ROUTE === 'alarm.update.alarm-notification') ? 'active' : '' }}" role="tab">{{ __('alarm-update.notifications') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
