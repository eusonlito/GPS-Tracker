<?php
namespace App\Domains\Permissions\Policies;

use App\Domains\User\Model\User;
use App\Domains\Permissions\Model\Permission;

class PermissionPolicy
{
    public function edit(User $user, Permission $permission)
    {
        // Add your authorization logic here
        return true; // Temporary, replace with actual logic
    }

    public function delete(User $user, Permission $permission)
    {
        // Add your authorization logic here
        return true; // Temporary, replace with actual logic
    }
}