@extends ('layouts.in')

@section ('body')

<div class="flex mb-2 mb-5 border-b-2">
    <h2 class="text-lg font-medium truncate"><a href="{{ route('server.log') }}">@icon('home', 'w-5 h-5')</a></h2>

    <div class="flex-1 mx-2">
        @foreach ($breadcrumb as $each)
        <h2 class="inline-block text-lg font-medium truncate">/</h2>
        <h2 class="inline-block text-lg font-medium truncate"><a href="{{ route('server.log', ['path' => $each->hash]) }}">{{ $each->name }}</a></h2>
        @endforeach
    </div>

    @if ($is_file)
    <a href="#" data-copy="#log-contents">@icon('clipboard', 'w-5 h-5')</a>
    @endif
</div>

@if ($is_file)

<pre id="log-contents" class="p-2 bg-white w-full max-h-screen overflow-x-auto">{{ $contents }}</pre>

@else

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table class="table table-report sm:mt-2 font-medium font-semibold text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th>{{ __('server-log.name') }}</th>
                <th>{{ __('server-log.type') }}</th>
                <th>{{ __('server-log.updated_at') }}</th>
                <th>{{ __('server-log.size') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $each)

            @php ($link = route('server.log', ['path' => $each->hash]))

            <tr>
                <td><a href="{{ $link }}" class="block">{{ $each->name }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $each->type }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $each->updated_at }}</a></td>
                <td><a href="{{ $link }}" class="block">{{ $each->size }}</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endif

@stop
