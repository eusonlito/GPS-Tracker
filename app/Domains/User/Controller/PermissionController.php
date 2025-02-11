<?php

namespace App\Domains\User\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Hiển thị danh sách quyền của một người dùng.
     */
    public function edit($userId)
{
    $this->authorize('view_users'); // Kiểm tra quyền trước khi truy cập

    $user = User::findOrFail($userId);
    $permissions = Permission::all();
    $userPermissions = $user->permissions->pluck('id')->toArray();

    return view('user.molecules.create-update', compact('user', 'permissions', 'userPermissions'));
}

public function update(Request $request, $userId)
{
    $this->authorize('edit_users'); // Kiểm tra quyền trước khi cập nhật

    $user = User::findOrFail($userId);
    $permissionIds = $request->input('permissions', []);
    $permissions = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();
    $user->syncPermissions($permissions);

    return redirect()->route('user.index')->with('success', 'Permissions updated successfully.');
}

}
