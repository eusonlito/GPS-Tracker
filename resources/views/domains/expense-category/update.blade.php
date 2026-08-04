@extends ('layouts.in')

@section ('body')

@if ($users_multiple && $row->user_id)

<div class="box p-5 mt-5">
    <div class="p-2">
        <x-select name="user_id" :options="$users" value="id" text="name" id="expense-category-update-user" :label="__('expense-category-update.user')" readonly disabled></x-select>
    </div>
</div>

@endif

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.expense-category.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            @if (($system === false) && (($global === false) || $AUTH->admin))

            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('expense-category-update.delete-button') }}</a>

            @endif

            <button type="submit" class="btn btn-primary" data-click-one>{{ __('expense-category-update.save') }}</button>
        </div>
    </div>
</form>

@if (($system === false) && (($global === false) || $AUTH->admin))

@include ('molecules.delete-modal')

@endif

@stop
