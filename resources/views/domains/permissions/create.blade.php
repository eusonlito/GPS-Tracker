<!-- @extends('layouts.app')

@section('content')
    <h2>Create Permission</h2>
    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Permission Name">
        <button type="submit">Create</button>
    </form>
@endsection -->
@extends('layouts.in')

@section('title', 'Create Permission')

@section('body')
    <h2>Create New Permission</h2>

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Permission Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Back</a>
    </form>
@endsection
