@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('user.update', $row->id) }}" class="p-4 {{ ($ROUTE === 'user.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>
        <a href="{{ route('user.update.user-session', $row->id) }}" class="p-4 {{ ($ROUTE === 'user.update.user-session') ? 'active' : '' }}" role="tab">{{ __('user-update.sessions') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" tab="tabpanel">
        @yield('content')
    </div>
</div>

@stop
