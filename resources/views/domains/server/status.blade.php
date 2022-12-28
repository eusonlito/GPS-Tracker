@extends ('layouts.in')

@section ('body')

@if ($process->isNotEmpty())

<form method="post">
    <div class="box p-5">
        <div class="overflow-auto lg:overflow-visible header-sticky">
            <table id="server-status-proccess-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                <thead>
                    <tr>
                        <th>{{ __('server-status.port') }}</th>
                        <th>{{ __('server-status.pid') }}</th>
                        <th>{{ __('server-status.owner') }}</th>
                        <th>{{ __('server-status.started') }}</th>
                        <th>{{ __('server-status.time') }}</th>
                        <th>{{ __('server-status.command') }}</th>
                        <th class="w-1"><input type="checkbox" data-checkall="#server-status-proccess-list-table > tbody" /></th>
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
                        <td class="w-1"><input type="checkbox" name="ports[]" value="{{ $each->port }}" /></td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right mt-5">
            <button type="submit" name="_action" value="stopPorts" class="btn btn-outline-danger ">{{ __('server-status.stop') }}</button>
        </div>
    </div>
</form>

@endif

<form method="post">
    <div class="box p-5 {{ $process->isNotEmpty() ? 'mt-5' : '' }}">
        <div class="overflow-auto lg:overflow-visible header-sticky">
            <table id="server-status-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
                <thead>
                    <tr>
                        <th>{{ __('server-status.port') }}</th>
                        <th>{{ __('server-status.protocol') }}</th>
                        <th>{{ __('server-status.debug') }}</th>
                        <th>{{ __('server-status.enabled') }}</th>
                        <th class="w-1"><input type="checkbox" data-checkall="#server-status-list-table > tbody" /></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($list as $row)

                    <tr>
                        <td>{{ $row->port }}</td>
                        <td>{{ $row->protocol }}</td>
                        <td class="w-1" data-table-sort-value="{{ (int)$row->debug }}"><a href="{{ route('server.update.boolean', [$row->id, 'debug']) }}" class="block" data-update-boolean="debug">@status($row->debug)</a></td>
                        <td data-table-sort-value="{{ (int)$row->enabled }}"><span class="block">@status($row->enabled)</span></td>
                        <td class="w-1">@if ($row->enabled) <input type="checkbox" name="ports[]" value="{{ $row->port }}" /> @endif</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="text-right mt-5">
            <button type="submit" name="_action" value="startPorts" class="btn btn-primary">{{ __('server-status.restart') }}</button>
        </div>
    </div>
</form>

@stop
