<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="{{ route('dashboard.index') }}">
            @icon('home', 'w-6 h-6 text-white')
        </a>

        <h1 class="flex-1 px-4 truncate">{{ Meta::get('title') }}</h1>

        <a href="javascript:;" id="mobile-menu-toggler">
            @icon('menu', 'w-8 h-8 text-white')
        </a>
    </div>

    <ul class="border-t hidden">
        <li>
            <a href="{{ route('dashboard.index') }}" class="menu {{ str_starts_with($ROUTE, 'dashboard.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('home')</div>
                <div class="menu__title">{{ __('in-sidebar.dashboard') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('trip.index') }}" class="menu {{ str_starts_with($ROUTE, 'trip.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('map')</div>
                <div class="menu__title">{{ __('in-sidebar.trip') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('refuel.index') }}" class="menu {{ str_starts_with($ROUTE, 'refuel.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('battery-charging')</div>
                <div class="menu__title">{{ __('in-sidebar.refuel') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('maintenance.index') }}" class="menu {{ str_starts_with($ROUTE, 'maintenance.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('tool')</div>
                <div class="menu__title">{{ __('in-sidebar.maintenance') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('vehicle.index') }}" class="menu {{ str_starts_with($ROUTE, 'vehicle.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('truck')</div>
                <div class="menu__title">{{ __('in-sidebar.vehicle') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('device.index') }}" class="menu {{ str_starts_with($ROUTE, 'device.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('cpu')</div>
                <div class="menu__title">{{ __('in-sidebar.device') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('alarm.index') }}" class="menu {{ str_starts_with($ROUTE, 'alarm.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('bell')</div>
                <div class="menu__title">{{ __('in-sidebar.alarm') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('alarm-notification.index') }}" class="menu {{ str_starts_with($ROUTE, 'alarm-notification.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('alert-triangle')</div>
                <div class="menu__title">{{ __('in-sidebar.alarm-notification') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('profile.update') }}" class="menu {{ str_starts_with($ROUTE, 'profile.update') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('user')</div>
                <div class="menu__title">{{ __('in-sidebar.profile') }}</div>
            </a>
        </li>

        @if ($AUTH->admin)

        <li>
            <a href="{{ route('configuration.index') }}" class="menu {{ str_starts_with($ROUTE, 'configuration.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('settings')</div>
                <div class="menu__title">{{ __('in-sidebar.configuration') }}</div>
            </a>
        </li>

        @php ($active = str_starts_with($ROUTE, 'user.'))

        <li>
            <a href="javascript:;" class="menu {{ $active ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('users')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.user') }} <div class="menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('user.index') }}" class="menu {{ $active ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.user-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.user-session') }}" class="menu {{ ($ROUTE === 'user.user-session') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('key')</div>
                        <div class="menu__title">{{ __('in-sidebar.user-session') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.ip-lock') }}" class="menu {{ ($ROUTE === 'user.ip-lock') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('lock')</div>
                        <div class="menu__title">{{ __('in-sidebar.user-ip-lock') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="javascript:;" class="menu {{ str_starts_with($ROUTE, 'server.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('radio')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.server') }} <div class="menu__sub-icon">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ str_starts_with($ROUTE, 'server.') ? 'menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('server.status') }}" class="menu {{ ($ROUTE === 'server.status') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('activity')</div>
                        <div class="menu__title">{{ __('in-sidebar.server-status') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('server.index') }}" class="menu {{ in_array($ROUTE, ['server.index', 'server.create', 'server.update']) ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.server-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('server.log') }}" class="menu {{ ($ROUTE === 'server.log') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('file-text')</div>
                        <div class="menu__title">{{ __('in-sidebar.server-log') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('timezone.index') }}" class="menu {{ str_starts_with($ROUTE, 'timezone.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('globe')</div>
                <div class="menu__title">{{ __('in-sidebar.timezone') }}</div>
            </a>
        </li>

        @endif

        <li>
            <a href="{{ route('user.logout') }}" class="menu">
                <div class="menu__icon">@icon('toggle-right')</div>
                <div class="menu__title">{{ __('in-sidebar.logout') }}</div>
            </a>
        </li>
    </ul>
</div>
