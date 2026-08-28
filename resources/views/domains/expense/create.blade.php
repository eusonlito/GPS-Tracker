@extends ('layouts.in')

@section ('body')

@if ($users_multiple)

<div class="box p-5 mt-5">
    <div class="p-2">
        <form method="get">
            <x-select name="user_id" :options="$users" value="id" text="name" id="expense-create-user" :label="__('expense-create.user')" :selected="$REQUEST->input('user_id')" data-change-submit required></x-select>
        </form>
    </div>
</div>

@endif

<form method="post" enctype="multipart/form-data">
    <input type="hidden" name="_action" value="create" />
    <input type="hidden" name="user_id" value="{{ $user->id }}" />

    @include ('domains.expense.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('expense-create.save') }}</button>
        </div>
    </div>
</form>

@stop
