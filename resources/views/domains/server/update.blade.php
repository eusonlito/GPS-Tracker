@extends ('domains.server.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.server.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <a href="javascript:;" data-toggle="modal" data-target="#delete-modal" class="btn btn-outline-danger mr-5">{{ __('server-update.delete-button') }}</a>
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('server-update.save') }}</button>
        </div>
    </div>
</form>

@include ('molecules.delete-modal')

@stop
