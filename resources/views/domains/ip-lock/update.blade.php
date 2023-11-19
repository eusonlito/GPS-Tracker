@extends ('domains.ip-lock.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.ip-lock.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary" data-click-one>{{ __('ip-lock-update.save') }}</button>
        </div>
    </div>
</form>

@stop
