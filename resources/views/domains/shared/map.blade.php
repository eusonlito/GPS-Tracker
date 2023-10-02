@extends ('layouts.empty')

@section ('body')

<div class="my-5">
    <div class="box px-5 py-2 mb-5">
        <a href="{{ $shared_url }}">&laquo; {{ __('common.back')}}</a>
    </div>

    <x-map-device :devices="$devices"></x-map-device>
</div>

@stop
