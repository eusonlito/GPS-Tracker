@extends ('layouts.in')

@section ('body')

<div class="box p-5 mt-5">
    <div class="p-2">
        <form method="get">
            <x-select name="type" id="alarm-create-type" :options="$types" :label="__('alarm-create.type')" :selected="$REQUEST->input('type')" :placeholder="__('alarm-create.type-select')" data-change-submit required></x-select>
        </form>
    </div>
</div>

@if ($type)

<form method="post">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="type" value="{{ $type }}" />

    @include ('domains.alarm.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('alarm-create.save') }}</button>
        </div>
    </div>
</form>

@endif

@stop
