@extends ('layouts.in')

@section ('body')

@if ($process->isNotEmpty())

<div class="box p-5 mt-5">
    <div class="overflow-auto lg:overflow-visible header-sticky">
        <table class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
            <thead>
                <tr>
                    <th>{{ __('socket-index.port') }}</th>
                    <th>{{ __('socket-index.pid') }}</th>
                    <th>{{ __('socket-index.owner') }}</th>
                    <th>{{ __('socket-index.start') }}</th>
                    <th>{{ __('socket-index.time') }}</th>
                    <th>{{ __('socket-index.command') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($process as $each)

                <tr>
                    <td class="font-semibold whitespace-nowrap">{{ $each->port }}</td>
                    <td class="font-semibold whitespace-nowrap">{{ $each->pid }}</td>
                    <td class="font-semibold whitespace-nowrap">{{ $each->owner }}</td>
                    <td class="font-semibold whitespace-nowrap">{{ $each->start }}</td>
                    <td class="font-semibold whitespace-nowrap">{{ $each->time }}</td>
                    <td class="font-semibold whitespace-nowrap">{{ $each->command }}</td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endif

<form method="post">
    <div class="box p-5 mt-5">
        <div class="overflow-auto lg:overflow-visible header-sticky">
            <table class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
                <thead>
                    <tr>
                        <th>{{ __('socket-index.port') }}</th>
                        <th>{{ __('socket-index.protocol') }}</th>
                        <th class="w-1">{{ __('socket-index.select') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($sockets as $port => $protocol)

                    <tr>
                        <td class="font-semibold whitespace-nowrap">{{ $port }}</td>
                        <td class="font-semibold whitespace-nowrap">{{ $protocol }}</td>
                        <td class="w-1"><input type="checkbox" name="ports[]" value="{{ $port }}" /></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" name="_action" value="killPorts" class="btn btn-outline-danger mr-5">{{ __('socket-index.kill') }}</button>
            <button type="submit" name="_action" value="serverPorts" class="btn btn-primary mr-5">{{ __('socket-index.start') }}</button>
        </div>
    </div>
</form>


@stop
