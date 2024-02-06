<div class="flex mb-2 mb-5 border-b-2">
    <h2 class="text-lg font-medium"><a href="{{ route('monitor.log') }}">@icon('home', 'w-5 h-5')</a></h2>

    <div class="flex-1 mx-2">
        @foreach ($breadcrumb as $each)

        <h2 class="inline-block text-lg font-medium">/</h2>
        <h2 class="inline-block text-lg font-medium"><a href="{{ route('monitor.log', ['path' => $each->hash]) }}" title="{{ $each->name }}">{{ $each->name }}</a></h2>

        @endforeach
    </div>
</div>
