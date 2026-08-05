@extends ('layouts.in')

@section ('body')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <x-select name="user_id" :options="$users" value="id" text="name" id="expense-update-user" :label="__('expense-update.user')" readonly disabled></x-select>
    </div>
</div>

@endif

@if ($related)

<div class="box p-5 mt-5">
    <div class="p-2 text-slate-500">
        {{ __('expense-update.related-message') }}

        @if ($row->maintenance_id)
        <a href="{{ route('maintenance.update', $row->maintenance_id) }}" class="text-primary">{{ __('expense-update.related-maintenance') }}</a>
        @endif

        @if ($row->refuel_id)
        <a href="{{ route('refuel.update', $row->refuel_id) }}" class="text-primary">{{ __('expense-update.related-refuel') }}</a>
        @endif
    </div>
</div>

@include ('domains.expense.molecules.create-update', ['readonly' => true])

@else

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.expense.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('expense-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('expense-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal')

@endif

@stop
