@extends ('layouts.in')

@section ('body')

<div class="lg:grid grid-cols-3 gap-6 p-2">
    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.system') }}
            </h2>
        </div>

        <div class="p-5">
            <div class="mb-5">
                <div class="flex">
                    <div class="mr-auto">{{ __('monitor-index.memory-summary', ['total' => helper()->sizeHuman($memory), 'load' => helper()->sizeHuman($memory_load)]) }}</div>
                    <div>{{ $memory_percent }}%</div>
                </div>

                <div class="w-full bg-slate-200 rounded mt-2 h-1">
                    <div role="progressbar" aria-valuenow="{{ $memory_percent }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $memory_percent }}%"></div>
                </div>
            </div>

            <div class="mb-5">
                <div class="flex">
                    <div class="mr-auto">{{ __('monitor-index.cpu-summary', ['total' => $cpu, 'load' => $cpu_load]) }}</div>
                    <div>{{ $cpu_percent }}%</div>
                </div>

                <div class="w-full bg-slate-200 rounded mt-2 h-1">
                    <div role="progressbar" aria-valuenow="{{ $cpu_percent }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $cpu_percent }}%"></div>
                </div>
            </div>

            <div class="mb-5">
                <div class="flex">
                    <div class="mr-auto">{{ __('monitor-index.disk-summary', ['total' => helper()->sizeHuman($disk), 'load' => helper()->sizeHuman($disk_load)]) }}</div>
                    <div>{{ $disk_percent }}%</div>
                </div>

                <div class="w-full bg-slate-200 rounded mt-2 h-1">
                    <div role="progressbar" aria-valuenow="{{ $disk_percent }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $disk_percent }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.memory') }}
            </h2>
        </div>

        <div class="p-5">
            @foreach ($memory_apps as $app)

            <div class="mb-5">
                <div class="flex">
                    <div class="mr-auto">{{ $app['app'] }}</div>
                    <div>@sizeHuman($app['memory'])</div>
                </div>

                <div class="w-full bg-slate-200 rounded mt-2 h-1">
                    <div role="progressbar" aria-valuenow="{{ $app['memory_percent'] }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $app['memory_percent'] }}%"></div>
                </div>
            </div>

            @endforeach
        </div>
    </div>

    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.cpu') }}
            </h2>
        </div>

        <div class="p-5">
            @foreach ($cpu_apps as $app)

            <div class="mb-5">
                <div class="flex">
                    <div class="mr-auto">{{ $app['app'] }}</div>
                    <div>{{ $app['cpu'] }}%</div>
                </div>

                <div class="w-full bg-slate-200 rounded mt-2 h-1">
                    <div role="progressbar" aria-valuenow="{{ $app['cpu_percent'] }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $app['cpu_percent'] }}%"></div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>
@stop
