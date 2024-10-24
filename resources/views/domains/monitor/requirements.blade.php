@extends ('layouts.in')

@section ('body')

<div class="lg:flex lg:space-x-4">
    <div class="flex-1">
        <div class="overflow-auto scroll-visible text-center header-sticky">
            <table class="table table-report sm:mt-2 font-medium font-semibold whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('monitor-requirements.name') }}</th>
                        <th>{{ __('monitor-requirements.path') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($commands as $name => $path)

                    <tr>
                        <td>{{ $name }}</td>
                        <td class="{{ $path ? 'text-success' : 'text-danger' }}">{{ $path ?: __('monitor-requirements.command-not-available') }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex-1">
        <div class="overflow-auto scroll-visible text-center header-sticky">
            <table class="table table-report sm:mt-2 font-medium font-semibold whitespace-nowrap">
                <thead>
                    <tr>
                        <th class="text-left">{{ __('monitor-requirements.name') }}</th>
                        <th>{{ __('monitor-requirements.status') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($functions as $name => $available)

                    <tr>
                        <td>{{ $name }}</td>
                        <td class="{{ $available ? 'text-success' : 'text-danger' }}">{{ $available ? __('monitor-requirements.function-available') : __('monitor-requirements.function-not-available') }}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<iframe src="data:text/html;charset=utf-8;base64,{{ $phpinfo }}" class="border-0 mt-5 w-full" style="height: 800px"></iframe>

@stop
