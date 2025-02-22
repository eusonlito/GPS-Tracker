<li>
    <a href="{{ route('dashboard.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'dashboard.') ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('home')</div>
        <div class="side-menu__title">{{ __('in-sidebar.dashboard') }}</div>
    </a>
</li>

@php ($active = str_starts_with($ROUTE, 'trip.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('map')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.trip') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('trip.index') }}" class="side-menu {{ ($ROUTE === 'trip.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.trip-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('trip.search') }}" class="side-menu {{ ($ROUTE === 'trip.search') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('search')</div>
                <div class="side-menu__title">{{ __('in-sidebar.trip-search') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('trip.map') }}" class="side-menu {{ ($ROUTE === 'trip.map') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('map')</div>
                <div class="side-menu__title">{{ __('in-sidebar.trip-map') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('trip.heatmap') }}" class="side-menu {{ ($ROUTE === 'trip.heatmap') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('thermometer')</div>
                <div class="side-menu__title">{{ __('in-sidebar.trip-heatmap') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'refuel.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('battery-charging')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.refuel') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('refuel.index') }}" class="side-menu {{ ($ROUTE === 'refuel.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.refuel-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('refuel.create') }}" class="side-menu {{ ($ROUTE === 'refuel.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.refuel-create') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('refuel.map') }}" class="side-menu {{ ($ROUTE === 'refuel.map') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('map')</div>
                <div class="side-menu__title">{{ __('in-sidebar.refuel-map') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'maintenance'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('tool')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.maintenance') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('maintenance.index') }}" class="side-menu {{ ($ROUTE === 'maintenance.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.maintenance-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('maintenance.create') }}" class="side-menu {{ ($ROUTE === 'maintenance.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.maintenance-create') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('maintenance-item.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'maintenance-item.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('shopping-bag')</div>
                <div class="side-menu__title">{{ __('in-sidebar.maintenance-item') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'vehicle.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('truck')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.vehicle') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('vehicle.index') }}" class="side-menu {{ ($ROUTE === 'vehicle.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.vehicle-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('vehicle.create') }}" class="side-menu {{ ($ROUTE === 'vehicle.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.vehicle-create') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('vehicle.map') }}" class="side-menu {{ ($ROUTE === 'vehicle.map') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('map')</div>
                <div class="side-menu__title">{{ __('in-sidebar.vehicle-map') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'device.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('cpu')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.device') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('device.index') }}" class="side-menu {{ ($ROUTE === 'device.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.device-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('device.create') }}" class="side-menu {{ ($ROUTE === 'device.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.device-create') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('device.map') }}" class="side-menu {{ ($ROUTE === 'device.map') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('map')</div>
                <div class="side-menu__title">{{ __('in-sidebar.device-map') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'alarm'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('bell')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.alarm') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('alarm.index') }}" class="side-menu {{ ($ROUTE === 'alarm.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.alarm-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('alarm.create') }}" class="side-menu {{ ($ROUTE === 'alarm.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.alarm-create') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('alarm-notification.index') }}" class="side-menu {{ ($ROUTE === 'alarm-notification.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('alert-triangle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.alarm-notification') }}</div>
            </a>
        </li>
    </ul>
</li>
{{--start add item Enterprise--}}
@php ($active = str_starts_with($ROUTE, 'enterprise'))
<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('briefcase')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.enterprise') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="/enterprise" class="side-menu {{ ($ROUTE === 'enterprise.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.enterprise-index') }}</div>
            </a>
        </li>
    </ul>

{{--end add item Enterprise--}}
@if ($AUTH->adminMode())

@php ($active = str_starts_with($ROUTE, 'user') || str_starts_with($ROUTE, 'ip-lock.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('users')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.user') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('user.index') }}" class="side-menu {{ ($ROUTE === 'user.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.user-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user.create') }}" class="side-menu {{ ($ROUTE === 'user.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.user-create') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('user-session.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'user-session.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('key')</div>
                <div class="side-menu__title">{{ __('in-sidebar.user-session') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('ip-lock.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'ip-lock.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('lock')</div>
                <div class="side-menu__title">{{ __('in-sidebar.ip-lock') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'server.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('radio')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.server') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('server.status') }}" class="side-menu {{ ($ROUTE === 'server.status') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('activity')</div>
                <div class="side-menu__title">{{ __('in-sidebar.server-status') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('server.index') }}" class="side-menu {{ ($ROUTE === 'server.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.server-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('server.create') }}" class="side-menu {{ ($ROUTE === 'server.create') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('plus-circle')</div>
                <div class="side-menu__title">{{ __('in-sidebar.server-create') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'city.') || str_starts_with($ROUTE, 'state.') || str_starts_with($ROUTE, 'country.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('map-pin')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.location') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('city.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'city.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.city-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('state.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'state.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.state-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('country.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'country.') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('list')</div>
                <div class="side-menu__title">{{ __('in-sidebar.country-index') }}</div>
            </a>
        </li>
    </ul>
</li>

@php ($active = str_starts_with($ROUTE, 'monitor.'))

<li>
    <a href="javascript:;" class="side-menu {{ $active ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('activity')</div>
        <div class="side-menu__title">
            {{ __('in-sidebar.monitor') }} <div class="side-menu__sub-icon {{ $active ? 'transform rotate-180' : '' }}">@icon('chevron-down')</div>
        </div>
    </a>

    <ul class="{{ $active ? 'side-menu__sub-open' : '' }}">
        <li>
            <a href="{{ route('monitor.index') }}" class="side-menu {{ ($ROUTE === 'monitor.index') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('server')</div>
                <div class="side-menu__title">{{ __('in-sidebar.monitor-index') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('monitor.installation') }}" class="side-menu {{ ($ROUTE === 'monitor.installation') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('git-merge')</div>
                <div class="side-menu__title">{{ __('in-sidebar.monitor-installation') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('monitor.database') }}" class="side-menu {{ ($ROUTE === 'monitor.database') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('database')</div>
                <div class="side-menu__title">{{ __('in-sidebar.monitor-database') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('monitor.log') }}" class="side-menu {{ ($ROUTE === 'monitor.log') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('file-text')</div>
                <div class="side-menu__title">{{ __('in-sidebar.monitor-log') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('monitor.queue') }}" class="side-menu {{ ($ROUTE === 'monitor.queue') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('layers')</div>
                <div class="side-menu__title">{{ __('in-sidebar.monitor-queue') }}</div>
            </a>
        </li>

        <li>
            <a href="{{ route('monitor.requirements') }}" class="side-menu {{ ($ROUTE === 'monitor.requirements') ? 'side-menu--active' : '' }}">
                <div class="side-menu__icon">@icon('check-square')</div>
                <div class="side-menu__title">{{ __('in-sidebar.monitor-requirements') }}</div>
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="{{ route('configuration.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'configuration.') ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('settings')</div>
        <div class="side-menu__title">{{ __('in-sidebar.configuration') }}</div>
    </a>
</li>

<li>
    <a href="{{ route('timezone.index') }}" class="side-menu {{ str_starts_with($ROUTE, 'timezone.') ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('globe')</div>
        <div class="side-menu__title">{{ __('in-sidebar.timezone') }}</div>
    </a>
</li>

@endif

<li>
    <a href="{{ route('profile.update') }}" class="side-menu {{ str_starts_with($ROUTE, 'profile.update') ? 'side-menu--active' : '' }}">
        <div class="side-menu__icon">@icon('user')</div>
        <div class="side-menu__title">{{ __('in-sidebar.profile') }}</div>
    </a>
</li>

<li>
    <a href="{{ route('user.logout') }}" class="side-menu">
        <div class="side-menu__icon">@icon('toggle-right')</div>
        <div class="side-menu__title">{{ __('in-sidebar.logout') }}</div>
    </a>
</li>
