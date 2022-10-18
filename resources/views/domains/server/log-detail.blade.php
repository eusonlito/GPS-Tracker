@extends ('layouts.in')

@section ('body')

<div class="flex mb-2 mb-5 border-b-2">
    <h2 class="text-lg font-medium truncate"><a href="{{ route('server.log') }}">@icon('home', 'w-5 h-5')</a></h2>

    @foreach ($breadcrumb as $each)
    <h2 class="text-lg font-medium truncate mx-2">/</h2>
    <h2 class="text-lg font-medium truncate"><a href="{{ route('server.log', ['path' => $each->hash]) }}">{{ $each->name }}</a></h2>
    @endforeach
</div>

@if ($is_file)

<pre class="p-2 bg-white w-100 max-h-screen overflow-x-auto">{{ $contents }}</pre>

@else

<div class="overflow-auto md:overflow-visible header-sticky">
    <table class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort>
        <thead>
            <tr>
                <th class="text-center">{{ __('server-log.name') }}</th>
                <th class="text-center">{{ __('server-log.type') }}</th>
                <th class="text-center">{{ __('server-log.updated_at') }}</th>
                <th class="text-center">{{ __('server-log.size') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $each)

            @php ($link = route('server.log', ['path' => $each->hash]))

            <tr>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $each->name }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $each->type }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $each->updated_at }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $each->size }}</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endif

@stop
