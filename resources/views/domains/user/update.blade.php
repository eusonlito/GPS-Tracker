@extends ('domains.user.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.user.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            @if ($can_be_deleted)
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('user-update.delete-button') }}</a>
            @endif

            <button type="submit" class="btn btn-primary" data-click-one>{{ __('user-update.save') }}</button>
        </div>
    </div>
</form>

@includeWhen ($can_be_deleted, 'molecules.delete-modal', [
    'title' => __('user-update.delete-title'),
    'message' => __('user-update.delete-message'),
])

@stop
