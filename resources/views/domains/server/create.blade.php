@extends ('layouts.in')

@section ('body')

<form method="post">
    <input type="hidden" name="_action" value="create" />

    @include ('domains.server.molecules.create-update')

    <div class="box p-5 mt-5">
        <div class="text-right">
            <button type="submit" class="btn btn-primary">{{ __('server-create.save') }}</button>
        </div>
    </div>
</form>

@stop
