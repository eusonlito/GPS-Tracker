@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('state.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'state.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
        <a href="{{ route('state.update.merge', $row->id) }}" class="p-4 {{ ($ROUTE === 'state.update.merge') ? 'active' : '' }}" role="tab">{{ __('state-update.merge') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        @yield('content')
    </div>
</div>

@stop
