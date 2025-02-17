<!-- @extends('layouts.app')

@section('content')
    <h2>Edit Permission</h2>
    <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $permission->name }}">
        <button type="submit">Update</button>
    </form>
@endsection -->
@extends('layouts.app')

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
@endsection
