@extends ('layouts.in')

@section ('body')

<div class="box flex items-center px-5">
    <div class="nav nav-tabs flex overflow-auto whitespace-nowrap" role="tablist">
        <a href="{{ route('profile.update') }}" class="p-4 {{ ($ROUTE === 'profile.update') ? 'active' : '' }}" role="tab">{{ $row->name }}</a>

        @if ($telegram)
        <a href="{{ route('profile.update.telegram') }}" class="p-4 {{ ($ROUTE === 'profile.update.telegram') ? 'active' : '' }}" role="tab">{{ __('profile-update.telegram') }}</a>
        @endif

        <a href="{{ route('profile.update.user-session') }}" class="p-4 {{ ($ROUTE === 'profile.update.user-session') ? 'active' : '' }}" role="tab">{{ __('profile-update.sessions') }}</a>
    </div>
</div>

<div class="tab-content">
    <div class="tab-pane active" tab="tabpanel">
        @yield('content')
    </div>
</div>

@stop
