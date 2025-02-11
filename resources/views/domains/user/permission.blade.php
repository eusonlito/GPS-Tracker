@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">User Permissions</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Permission</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>View Users</td>
                <td>
                    <a href="{{ route('permissions.edit', 'view_users') }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            <tr>
                <td>Edit Users</td>
                <td>
                    <a href="{{ route('permissions.edit', 'edit_users') }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            <tr>
                <td>Delete Users</td>
                <td>
                    <a href="{{ route('permissions.edit', 'delete_users') }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
            <tr>
                <td>Manage Services</td>
                <td>
                    <a href="{{ route('permissions.edit', 'manage_services') }}" class="btn btn-primary btn-sm">Edit</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
