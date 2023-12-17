@php ($step = 0)

<div class="max-w-xl mx-auto">
    <h1 class="text-3xl font-medium leading-none text-center my-10">
        {{ __('dashboard-onboarding.title') }}
    </h1>

    @if ($users_multiple)

    <div class="box p-5 mb-5">
        <form method="GET">
            <x-select name="user_id" :options="$users" value="id" text="name" data-change-submit></x-select>
        </form>
    </div>

    @endif

    @if ($AUTH->adminMode())

    <a href="{{ $server ? route('server.status') : route('server.create') }}" class="box flex items-center mb-5">
        <div class="text-4xl font-bold py-5 px-9">
            {{ ++$step }}
        </div>

        <div class="flex-none py-5">
            <img src="@asset('build/images/server.svg')" class="w-14 w-lg-32 max-h-16" />
        </div>

        <div class="p-5 flex-1">
            @if ($server)

            <span class="text-xl font-bold strikethrough">{{ __('dashboard-onboarding.server.title') }}</span>
            <p class="w-full text-slate-500 mt-0.5">{{ __('dashboard-onboarding.server.text', ['protocol' => $server->protocol, 'port' => $server->port]) }}</p>

            @else

            <span class="text-xl font-bold">{{ __('dashboard-onboarding.server.title') }}</span>
            <p class="w-full text-slate-500 mt-0.5">{{ __('dashboard-onboarding.server.text-peding') }}</p>

            @endif
        </div>
    </a>

    @endif

    <{!! $vehicle ? 'div' : ('a href="'.route('vehicle.create').'"') !!} class="box flex items-center mb-5">
        <div class="text-4xl font-bold py-5 px-9">
            {{ ++$step }}
        </div>

        <div class="flex-none py-5">
            <img src="@asset('build/images/vehicle.svg')" class="w-14 w-lg-32 max-h-16" />
        </div>

        <div class="p-5 flex-1">
            @if ($vehicle)

            <span class="text-xl font-bold strikethrough">{{ __('dashboard-onboarding.vehicle.title') }}</span>

            <form method="GET">
                <x-select name="vehicle_id" :options="$vehicles" value="id" text="name" data-change-submit></x-select>
            </form>

            @else

            <span class="text-xl font-bold">{{ __('dashboard-onboarding.vehicle.title') }}</span>
            <p class="w-full text-slate-500 mt-0.5">{{ __('dashboard-onboarding.vehicle.text-peding') }}</p>

            @endif
        </div>
    </{{ $vehicle ? 'div' : 'a' }}>

    <{!! $device ? 'div' : ('a href="'.route('device.create').'"') !!} class="box flex items-center mb-5">
        <div class="text-4xl font-bold py-5 px-9">
            {{ ++$step }}
        </div>

        <div class="flex-none py-5">
            <img src="@asset('build/images/device.svg')" class="w-14 w-lg-32 max-h-16" />
        </div>

        <div class="p-5 flex-1">
            @if ($device)

            <span class="text-xl font-bold strikethrough">{{ __('dashboard-onboarding.device.title') }}</span>

            <form method="GET">
                <x-select name="device_id" :options="$devices" value="id" text="name" data-change-submit></x-select>
            </form>

            @else

            <span class="text-xl font-bold">{{ __('dashboard-onboarding.device.title') }}</span>
            <p class="w-full text-slate-500 mt-0.5">{{ __('dashboard-onboarding.device.text-peding') }}</p>

            @endif
        </div>
    </{{ $device ? 'div' : 'a' }}>

    <a href="{{ route('dashboard.index') }}" class="box flex items-center">
        <div class="text-4xl font-bold py-5 px-9">
            {{ ++$step }}
        </div>

        <div class="flex-none py-5">
            <img src="@asset('build/images/trip.svg')" class="w-14 w-lg-32 max-h-16" />
        </div>

        <div class="p-5 flex-1">
            <span class="text-xl font-bold">{{ __('dashboard-onboarding.trip.title') }}</span>
            <p class="w-full text-slate-500 mt-0.5">{{ __('dashboard-onboarding.trip.text') }}</p>
        </div>
    </a>
</div>
