@extends ('domains.server.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="parse" />

    <div class="box p-5 mt-5">
        <div class="p-2">
            <label for="server-log" class="form-label">{{ __('server-update-parser.log', ['name' => $protocol->name()]) }}</label>
            <textarea name="log" class="form-control form-control-lg" id="server-log" rows="10" required>{{ $REQUEST->input('log') }}</textarea>
        </div>
    </div>

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('server-update-parser.send') }}</button>
        </div>
    </div>
</form>

@if ($parsed)

<div class="max-h-screen overflow-x-auto header-sticky">
    <table id="server-list-table" class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap">
        <thead>
            <tr>
                <th class="w-1">{{ __('server-update-parser.date_at') }}</th>
                <th class="w-1">{{ __('server-update-parser.format') }}</th>
                <th class="w-1">{{ __('server-update-parser.serial') }}</th>
                <th class="w-1">{{ __('server-update-parser.device') }}</th>
                <th class="w-1">{{ __('server-update-parser.latitude') }}</th>
                <th class="w-1">{{ __('server-update-parser.longitude') }}</th>
                <th class="w-1">{{ __('server-update-parser.speed') }}</th>
                <th class="w-1">{{ __('server-update-parser.direction') }}</th>
                <th class="w-1">{{ __('server-update-parser.signal') }}</th>
                <th class="w-1">{{ __('server-update-parser.date_utc_at') }}</th>
                <th class="w-1">{{ __('server-update-parser.timezone') }}</th>
                <th class="w-1">{{ __('server-update-parser.response') }}</th>
                <th>{{ __('server-update-parser.line') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($parsed as $each)

            @forelse ($each['resources'] as $resource)

            <tr>
                <td class="text-left">{{ $each['date_at'] }}</td>

                <td>{{ $resource->format() }}</td>
                <td>{{ $resource->serial() }}</td>

                <td class="{{ $each['device'] ? 'text-success' : 'text-danger' }}">{{ $each['device']?->name ?: '-' }}</td>

                @if ($resource->format() === 'location')

                <td>{{ $resource->latitude() }}</td>
                <td>{{ $resource->longitude() }}</td>
                <td>{{ $resource->speed() }}</td>
                <td>{{ $resource->direction() }}</td>
                <td>{{ $resource->signal() }}</td>
                <td>{{ $resource->datetime() }}</td>
                <td>{{ $resource->timezone() }}</td>

                @else

                <td colspan="7"></td>

                @endif

                <td>{{ $resource->response() }}</td>

                <td class="text-left">{{ $resource->body() }}</td>
            </tr>

            @empty

            <tr>
                <td class="text-left">{{ $each['date_at'] }}</td>

                <td></td>
                <td></td>

                <td class="text-danger">-</td>

                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>

                <td></td>

                <td class="text-left">{{ $each['line'] }}</td>
            </tr>

            @endforelse

            @endforeach
        </tbody>
    </table>
</div>

@endif

@stop
