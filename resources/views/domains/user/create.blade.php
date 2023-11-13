@extends ('layouts.in')

@section ('body')

<div class="tab-content">
    <div class="tab-pane active" role="tabpanel">
        <form method="post">
            <input type="hidden" name="_action" value="create" />

            @include ('domains.user.molecules.create-update')

            <div class="box p-5 mt-5">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">{{ __('user-create.save') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@stop
