@extends ('layouts.in')

@section ('body')

@include ('domains.server.log-header')

<div class="mb-5 text-center">
    <button href="#" data-copy="#log-contents" class="btn bg-white">@icon('clipboard', 'w-5 h-5')</button>
</div>

<pre id="log-contents" class="p-2 bg-white w-full max-h-screen overflow-x-auto">{{ $contents }}</pre>

@stop
