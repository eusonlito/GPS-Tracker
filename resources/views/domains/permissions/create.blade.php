<!-- @extends('layouts.in')

@section('title', 'Create Permission')

@section('body')

    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_action" value="create" />

                @include ('domains.permissions.molecules.create-update')

                <div class="box p-5 mt-5 text-right">
                    <button type="submit" class="btn btn-success">Create</button>
                    <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>

@endsection -->


<!-- 
@extends('layouts.in')

@section('content')
    <div class="container">
        <h2>Create Permission</h2>

        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Role</label>
                <input type="number" name="role_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Action</label>
                <input type="number" name="action_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Entity</label>
                <input type="number" name="entity_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Enterprise (Optional)</label>
                <input type="number" name="enterprise_id" class="form-control">
            </div>

            <div class="mb-3">
                <label>Scope</label>
                <input type="number" name="scope_id" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Entity Record ID (Optional)</label>
                <input type="number" name="entity_record_id" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection -->


@extends('layouts.in')

@section('content')
    <div class="container">
        <h2>Create Permission</h2>
        <form action="{{ route('permissions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Role ID</label>
                <input type="number" name="role_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Action ID</label>
                <input type="number" name="action_id" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection