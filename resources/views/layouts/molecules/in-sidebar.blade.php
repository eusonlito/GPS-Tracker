<nav class="side-nav py-10">
    <ul>
        <li>
            <a href="{{ route('dashboard.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'dashboard.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('home')</div>
                <div class="side-menu__title">{{ __('in-sidebar.dashboard') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('trip.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'trip.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('map')</div>
                <div class="side-menu__title">{{ __('in-sidebar.trips') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('refuel.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'refuel.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('battery-charging')</div>
                <div class="side-menu__title">{{ __('in-sidebar.refuel') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('device.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'device.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('cpu')</div>
                <div class="side-menu__title">{{ __('in-sidebar.devices') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('alarm.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'alarm.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('bell')</div>
                <div class="side-menu__title">{{ __('in-sidebar.alarms') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('alarm-notification.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'alarm-notification.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('alert-triangle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.notifications') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.profile') }}" class="side-menu {{ ($ROUTE === 'user.profile') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('user')</div>
                <div class="side-menu__title">{{ __('in-sidebar.profile') }}</div>
            </a>
        </li>

        @if ($AUTH->admin)

        <li>
            <a href="{{ route('configuration.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'configuration.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('settings')</div>
                <div class="side-menu__title">{{ __('in-sidebar.configuration') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.index') }}" class="side-menu {{ (str_starts_with($ROUTE, 'user.') && ($ROUTE !== 'user.profile')) ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('users')</div>
                <div class="side-menu__title">{{ __('in-sidebar.users') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('socket.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'socket.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('radio')</div>
                <div class="side-menu__title">{{ __('in-sidebar.sockets') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('server.log') }}" class="side-menu {{ str_starts_with($ROUTE, 'server.log') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('file')</div>
                <div class="side-menu__title">{{ __('in-sidebar.logs') }}</div>
            </a>
        </li>

        @endif

        <li>
            <a href="{{ route('user.logout') }}" class="side-menu">
                <div class="side-menu__icon">@icon('toggle-right')</div>
                <div class="side-menu__title">{{ __('in-sidebar.logout') }}</div>
            </a>
        </li>
    </ul>
</nav>
