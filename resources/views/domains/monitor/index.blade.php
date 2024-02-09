@extends ('layouts.in')

@section ('body')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 p-2">
    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.memory') }}
            </h2>
        </div>

        <div class="border-b border-slate-200/60 p-5">
            <div class="flex">
                <div class="font-medium">
                    <span class="font-medium">@sizeHuman($memory_load)</span>
                    /
                    <span class="font-medium">@sizeHuman($memory)</span>
                </div>

                <div class="flex-1 w-full bg-slate-200 rounded h-5 ml-5">
                    <div role="progressbar" aria-valuenow="{{ $memory_percent }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex" style="background-color: #1e3a8a; width: {{ $memory_percent }}%"></div>
                </div>

                <div class="font-medium ml-5">
                    {{ $memory_percent }}%
                </div>
            </div>
        </div>

        <div class="p-5">
            @foreach ($memory_apps as $app)

            <div class="mb-3">
                <div class="flex">
                    <div class="flex-1 font-medium">{{ $app['app'] }}</div>
                    <div class="text-slate-500">@sizeHuman($app['memory'])</div>
                </div>

                <div class="flex mt-2 items-center">
                    <div class="flex-1 w-full bg-slate-200 rounded h-3">
                        <div role="progressbar" aria-valuenow="{{ $app['memory_percent'] }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $app['memory_percent'] }}%"></div>
                    </div>

                    <div class="text-slate-400 ml-3">{{ $app['memory_percent'] }}%</div>
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

        <div class="border-b border-slate-200/60 p-5">
            <div class="flex">
                <div class="font-medium">
                    <span class="font-medium">@number($cpu_load)</span>
                    /
                    <span class="font-medium">{{ $cpu }}</span>
                </div>

                <div class="flex-1 w-full bg-slate-200 rounded h-5 ml-5">
                    <div role="progressbar" aria-valuenow="{{ $cpu_percent }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex" style="background-color: #1e3a8a; width: {{ $cpu_percent }}%"></div>
                </div>

                <div class="font-medium ml-5">
                    {{ $cpu_percent }}%
                </div>
            </div>
        </div>

        <div class="p-5">
            @foreach ($cpu_apps as $app)

            <div class="mb-3">
                <div class="flex">
                    <div class="flex-1 font-medium">{{ $app['app'] }}</div>
                </div>

                <div class="flex mt-2 items-center">
                    <div class="flex-1 w-full bg-slate-200 rounded h-3">
                        <div role="progressbar" aria-valuenow="{{ $app['cpu_percent'] }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $app['cpu_percent'] }}%"></div>
                    </div>

                    <div class="text-slate-400 ml-3">@number($app['cpu_percent'])%</div>
                </div>
            </div>

            @endforeach
        </div>
    </div>

    <div class="box">
        <div class="border-b border-slate-200/60">
            <h2 class="text-base font-medium p-5">
                {{ __('monitor-index.disk') }}
            </h2>
        </div>

        <div class="border-b border-slate-200/60 p-5">
            <div class="flex">
                <div class="font-medium">
                    <span class="font-medium">@sizeHuman($disk_load)</span>
                    /
                    <span class="font-medium">@sizeHuman($disk)</span>
                </div>

                <div class="flex-1 w-full bg-slate-200 rounded h-5 ml-5">
                    <div role="progressbar" aria-valuenow="{{ $disk_percent }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex" style="background-color: #1e3a8a; width: {{ $disk_percent }}%"></div>
                </div>

                <div class="font-medium ml-5">
                    {{ $disk_percent }}%
                </div>
            </div>
        </div>

        <div class="p-5">
            @foreach ($disk_apps as $app)

            <div class="mb-3">
                <div class="flex">
                    <div class="flex-1 font-medium">{{ $app['mount'] }}</div>
                    <div class="text-slate-500">@sizeHuman($app['load']) / @sizeHuman($app['size'])</div>
                </div>

                <div class="flex mt-2 items-center">
                    <div class="flex-1 w-full bg-slate-200 rounded h-3">
                        <div role="progressbar" aria-valuenow="{{ $app['percent'] }}" aria-valuemin="0" aria-valuemax="100" class="h-full rounded flex justify-center items-center" style="background-color: #1e3a8a; width: {{ $app['percent'] }}%"></div>
                    </div>

                    <div class="text-slate-400 ml-3">{{ $app['percent'] }}%</div>
                </div>
            </div>

            @endforeach
        </div>
    </div>
</div>
@stop
