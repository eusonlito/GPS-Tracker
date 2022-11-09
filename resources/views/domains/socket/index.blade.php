@extends ('layouts.in')

@section ('body')

@if ($process->isNotEmpty())

<div class="box p-5 mt-5">
    <div class="overflow-auto lg:overflow-visible header-sticky">
        <table class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
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
                    <td>{{ $each->port }}</td>
                    <td>{{ $each->pid }}</td>
                    <td>{{ $each->owner }}</td>
                    <td>{{ $each->start }}</td>
                    <td>{{ $each->time }}</td>
                    <td>{{ $each->command }}</td>
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
            <table class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
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
                        <td>{{ $port }}</td>
                        <td>{{ $protocol }}</td>
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
