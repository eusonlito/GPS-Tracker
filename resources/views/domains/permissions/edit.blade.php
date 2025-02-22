<!-- @extends('layouts.in')

@section('title', 'Edit Permission')

@section('content')
    <h2>Edit Permission</h2>

    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection -->

@extends('layouts.in')

@section('content')
    <div class="container">
        <h2>Edit Permission</h2>

        <form action="{{ route('permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Role</label>
                <input type="number" name="role_id" value="{{ $permission->role_id }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Action</label>
                <input type="number" name="action_id" value="{{ $permission->action_id }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Entity</label>
                <input type="number" name="entity_id" value="{{ $permission->entity_id }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Enterprise (Optional)</label>
                <input type="number" name="enterprise_id" value="{{ $permission->enterprise_id }}" class="form-control">
            </div>

            <div class="mb-3">
                <label>Scope</label>
                <input type="number" name="scope_id" value="{{ $permission->scope_id }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Entity Record ID (Optional)</label>
                <input type="number" name="entity_record_id" value="{{ $permission->entity_record_id }}"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
@endsection