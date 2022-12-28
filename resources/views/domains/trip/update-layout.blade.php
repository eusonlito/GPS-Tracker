@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('trip.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'trip.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
        <a href="{{ route('trip.update.stat', $row->id) }}" class="p-4 {{ ($ROUTE === 'trip.update.stat') ? 'active' : '' }}" role="tab">{{ __('trip-update.stats') }}</a>
        <a href="{{ route('trip.update.map', $row->id) }}" class="p-4 {{ ($ROUTE === 'trip.update.map') ? 'active' : '' }}" role="tab">{{ __('trip-update.map') }}</a>
        <a href="{{ route('trip.update.position', $row->id) }}" class="p-4 {{ ($ROUTE === 'trip.update.position') ? 'active' : '' }}" role="tab">{{ __('trip-update.positions') }}</a>
        <a href="{{ route('trip.update.alarm-notification', $row->id) }}" class="p-4 {{ ($ROUTE === 'trip.update.alarm-notification') ? 'active' : '' }}" role="tab">{{ __('trip-update.alarms') }}</a>
        <a href="{{ route('trip.update.merge', $row->id) }}" class="p-4 {{ ($ROUTE === 'trip.update.merge') ? 'active' : '' }}" role="tab">{{ __('trip-update.merge') }}</a>
        <a href="{{ route('trip.update.export', $row->id) }}" class="p-4" role="tab">{{ __('trip-update.export') }}</a>

        @if ($previous)
        <a href="{{ route($ROUTE, $previous->id) }}" class="p-4" role="tab">&laquo; {{ __('trip-update.previous') }}</a>
        @else
        <span class="text-gray-300 p-4" role="tab">&laquo; {{ __('trip-update.previous') }}</span>
        @endif

        @if ($next)
        <a href="{{ route($ROUTE, $next->id) }}" class="p-4" role="tab">{{ __('trip-update.next') }} &raquo;</a>
        @else
        <span class="text-gray-300 p-4" role="tab">{{ __('trip-update.next') }} &raquo;</span>
        @endif
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
