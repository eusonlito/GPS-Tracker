@extends ('domains.configuration.update-layout')

@section ('content')

<form method="post">
    <input type="hidden" name="_action" value="update" />

    @include ('domains.configuration.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('configuration-update.save') }}</button>
        </div>
    </div>
</form>

@stop
