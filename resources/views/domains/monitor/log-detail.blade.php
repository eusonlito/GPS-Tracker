@extends ('layouts.in')

@section ('body')

@include ('domains.monitor.molecules.log-header')

<div class="mb-5 text-center">
    <button href="#" data-copy="#log-contents" class="btn bg-white">@icon('clipboard', 'w-5 h-5')</button>
    <button href="#" data-select="#log-contents" class="btn bg-white ml-5">@icon('check-square', 'w-5 h-5')</button>
    <button href="#" data-scroll-bottom="#log-contents" class="btn bg-white ml-5">@icon('chevrons-down', 'w-5 h-5')</button>
</div>

<pre id="log-contents" class="p-2 bg-white w-full max-h-screen-90 overflow-x-auto">@php ($contents())</pre>

@stop
