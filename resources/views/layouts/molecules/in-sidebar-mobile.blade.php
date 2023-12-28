<div class="mobile-menu md:hidden">
    <div class="mobile-menu-bar">
        <a href="{{ route('dashboard.index') }}" class="logo {{ str_starts_with($ROUTE, 'dashboard.') ? 'active' : '' }}">
            @svg('/build/images/logo.svg')
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

        @php ($active = str_starts_with($ROUTE, 'maintenance'))

        <li>
            <a href="javascript:;" class="menu {{ $active ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('tool')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.maintenance') }} <div class="menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('maintenance.index') }}" class="menu {{ ($ROUTE === 'maintenance.index') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.maintenance-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('maintenance-item.index') }}" class="menu {{ ($ROUTE === 'maintenance-item.index') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('shopping-bag')</div>
                        <div class="menu__title">{{ __('in-sidebar.maintenance-item') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        <li>
            <a href="{{ route('vehicle.index') }}" class="menu {{ str_starts_with($ROUTE, 'vehicle.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('truck')</div>
                <div class="menu__title">{{ __('in-sidebar.vehicle') }}</div>
            </a>
        </li>

        @php ($active = str_starts_with($ROUTE, 'device.'))

        <li>
            <a href="javascript:;" class="menu {{ $active ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('cpu')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.device') }} <div class="menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('device.index') }}" class="menu {{ ($active && ($ROUTE !== 'device.map')) ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.device-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('device.map') }}" class="menu {{ ($ROUTE === 'device.map') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('map')</div>
                        <div class="menu__title">{{ __('in-sidebar.device-map') }}</div>
                    </a>
                </li>
            </ul>
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

        @if ($AUTH->adminMode())

        <li>
            <a href="{{ route('configuration.index') }}" class="menu {{ str_starts_with($ROUTE, 'configuration.') ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('settings')</div>
                <div class="menu__title">{{ __('in-sidebar.configuration') }}</div>
            </a>
        </li>

        @php ($active = str_starts_with($ROUTE, 'user.') || str_starts_with($ROUTE, 'user-session.') || str_starts_with($ROUTE, 'ip-lock.'))

        <li>
            <a href="javascript:;" class="menu {{ $active ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('users')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.user') }} <div class="menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('user.index') }}" class="menu {{ str_starts_with($ROUTE, 'user.') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.user-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('user-session.index') }}" class="menu {{ str_starts_with($ROUTE, 'user-session.') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('key')</div>
                        <div class="menu__title">{{ __('in-sidebar.user-session') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('ip-lock.index') }}" class="menu {{ str_starts_with($ROUTE, 'ip-lock.') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('lock')</div>
                        <div class="menu__title">{{ __('in-sidebar.ip-lock') }}</div>
                    </a>
                </li>
            </ul>
        </li>

        @php ($active = str_starts_with($ROUTE, 'server.'))

        <li>
            <a href="javascript:;" class="menu {{ $active ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('radio')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.server') }} <div class="menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ $active ? 'menu__sub-open' : '' }}">
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

        @php ($active = str_starts_with($ROUTE, 'city.') || str_starts_with($ROUTE, 'state.') || str_starts_with($ROUTE, 'country.'))

        <li>
            <a href="javascript:;" class="menu {{ $active ? 'menu--active' : '' }}">
                <div class="menu__icon">@icon('map-pin')</div>
                <div class="menu__title">
                    {{ __('in-sidebar.location') }} <div class="menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
                </div>
            </a>

            <ul class="{{ str_starts_with($ROUTE, 'city.') ? 'menu__sub-open' : '' }}">
                <li>
                    <a href="{{ route('city.index') }}" class="menu {{ str_starts_with($ROUTE, 'city.') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.city-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('state.index') }}" class="menu {{ str_starts_with($ROUTE, 'state.') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.state-index') }}</div>
                    </a>
                </li>

                <li>
                    <a href="{{ route('country.index') }}" class="menu {{ str_starts_with($ROUTE, 'country.') ? 'menu--active' : '' }}">
                        <div class="menu__icon">@icon('list')</div>
                        <div class="menu__title">{{ __('in-sidebar.country-index') }}</div>
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
