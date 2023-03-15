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
            <a href="{{ route('vehicle.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'vehicle.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('truck')</div>
                <div class="side-menu__title">{{ __('in-sidebar.vehicles') }}</div>
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
            <a href="{{ route('profile.update') }}" class="side-menu {{ str_starts_with($ROUTE, 'profile.update') ? 'side-menu--active' : '' }}">
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

        @php ($active = str_starts_with($ROUTE, 'user.'))

        <li>
            <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('users')</div>
                <div class="side-menu__title">
                    {{ __('in-sidebar.users') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('user.index') }}" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">@icon('list')</div>
                        <div class="side-menu__title">{{ __('in-sidebar.users-list') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.user-session') }}" class="side-menu {{ ($ROUTE === 'user.user-session') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">@icon('key')</div>
                        <div class="side-menu__title">{{ __('in-sidebar.users-sessions') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.ip-lock') }}" class="side-menu {{ ($ROUTE === 'user.ip-lock') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">@icon('lock')</div>
                        <div class="side-menu__title">{{ __('in-sidebar.ip-locks') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        @php ($active = str_starts_with($ROUTE, 'server.'))

        <li>
            <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('radio')</div>
                <div class="side-menu__title">
                    {{ __('in-sidebar.servers') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('server.status') }}" class="side-menu {{ ($ROUTE === 'server.status') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">@icon('activity')</div>
                        <div class="side-menu__title">{{ __('in-sidebar.servers-status') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('server.index') }}" class="side-menu {{ in_array($ROUTE, ['server.index', 'server.create', 'server.update']) ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">@icon('list')</div>
                        <div class="side-menu__title">{{ __('in-sidebar.servers-list') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('server.log') }}" class="side-menu {{ ($ROUTE === 'server.log') ? 'side-menu--active' : '' }}">
                        <div class="side-menu__icon">@icon('file-text')</div>
                        <div class="side-menu__title">{{ __('in-sidebar.servers-logs') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('timezone.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'timezone.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('globe')</div>
                <div class="side-menu__title">{{ __('in-sidebar.timezones') }}</div>
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
