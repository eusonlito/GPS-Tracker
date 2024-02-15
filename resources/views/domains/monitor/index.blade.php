@extends ('layouts.in')

@section ('body')

<div class="box lg:flex items-stretch mb-6">
    <div class="border-b lg:border-b-0 lg:border-r border-slate-200/60 flex items-center">
        <h2 class="text-base font-medium p-5">
            {{ __('monitor-index.summary') }}
        </h2>
    </div>

    <div class="flex-1 p-5">
        @if ($summary)

        <code class="block border-b border-slate-200/60 pb-2">{{ $summary['uptime'] }}</code>
        <code class="block border-b border-slate-200/60 py-2">{{ $summary['tasks'] }}</code>
        <code class="block border-b border-slate-200/60 py-2">{{ $summary['cpus'] }}</code>
        <code class="block border-b border-slate-200/60 py-2">{{ $summary['memory'] }}</code>
        <code class="block pt-2">{{ $summary['swap'] }}</code>

        @else

        <div class="text-lg font-medium leading-none text-danger">{{ __('monitor-index.summary-not-available') }}</div>

        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.memory') }}
            </h2>
        </div>

        @if ($memory)

        <div class="border-b border-slate-200/60 p-5">
            <div class="flex">
                <div class="font-medium">
                    <span class="font-medium">@sizeHuman($memory['load'])</span>
                    /
                    <span class="font-medium">@sizeHuman($memory['size'])</span>
                </div>

                @progressbar($memory['percent'], 'flex-1 h-5 ml-5')

                <div class="font-medium ml-5">
                    {{ $memory['percent'] }}%
                </div>
            </div>
        </div>

        <div class="p-5">
            @foreach ($memory['apps'] as $app)

            <div class="mb-3">
                <div class="flex">
                    <div class="flex-1 font-medium">{{ $app['app'] }}</div>
                    <div class="text-slate-500">@sizeHuman($app['size'])</div>
                </div>

                <div class="flex mt-2 items-center">
                    @progressbar($app['percent'], 'flex-1 h-3')

                    <div class="text-slate-400 ml-3">{{ $app['percent'] }}%</div>
                </div>
            </div>

            @endforeach
        </div>

        @else

        <div class="p-5 text-lg font-medium leading-none text-danger">{{ __('monitor-index.memory-not-available') }}</div>

        @endif
    </div>

    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.cpu') }}
            </h2>
        </div>

        @if ($cpu)

        <div class="border-b border-slate-200/60 p-5">
            <div class="flex">
                <div class="font-medium">
                    <span class="font-medium">({{ implode(' ', $cpu['average']) }})</span>
                    /
                    <span class="font-medium">{{ $cpu['cores'] }}</span>
                </div>

                @progressbar($cpu['percent'], 'flex-1 h-5 ml-5')

                <div class="font-medium ml-5">
                    {{ $cpu['percent'] }}%
                </div>
            </div>
        </div>

        <div class="p-5">
            @foreach ($cpu['apps'] as $app)

            <div class="mb-3">
                <div class="flex">
                    <div class="flex-1 font-medium">{{ $app['app'] }}</div>
                </div>

                <div class="flex mt-2 items-center">
                    @progressbar($app['percent'], 'flex-1 h-3')

                    <div class="text-slate-400 ml-3">@number($app['percent'])%</div>
                </div>
            </div>

            @endforeach
        </div>

        @else

        <div class="p-5 text-lg font-medium leading-none text-danger">{{ __('monitor-index.cpu-not-available') }}</div>

        @endif
    </div>

    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.disk') }}
            </h2>
        </div>

        @if ($disk)

        <div class="border-b border-slate-200/60 p-5">
            <div class="flex">
                <div class="font-medium">
                    <span class="font-medium">@sizeHuman($disk['load'])</span>
                    /
                    <span class="font-medium">@sizeHuman($disk['size'])</span>
                </div>

                @progressbar($disk['percent'], 'flex-1 h-5 ml-5')

                <div class="font-medium ml-5">
                    {{ $disk['percent'] }}%
                </div>
            </div>
        </div>

        <div class="p-5">
            @foreach ($disk['mounts'] as $app)

            <div class="mb-3">
                <div class="flex">
                    <div class="flex-1 font-medium">{{ $app['path'] }}</div>
                    <div class="text-slate-500">@sizeHuman($app['load']) / @sizeHuman($app['size'])</div>
                </div>

                <div class="flex mt-2 items-center">
                    @progressbar($app['percent'], 'flex-1 h-3')

                    <div class="text-slate-400 ml-3">{{ $app['percent'] }}%</div>
                </div>
            </div>

            @endforeach
        </div>

        @else

        <div class="p-5 text-lg font-medium leading-none text-danger">{{ __('monitor-index.disk-not-available') }}</div>

        @endif
    </div>
</div>
@stop
