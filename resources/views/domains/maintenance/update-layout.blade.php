@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('maintenance.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'maintenance.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
    </div>

    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('maintenance.update.item', $row->id) }}" class="p-4 {{ ($ROUTE === 'maintenance.update.item') ? 'active' : '' }}" role="tab">{{ __('maintenance-update.items') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
