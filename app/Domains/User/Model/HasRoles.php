<?php

declare(strict_types=1);

namespace App\Domains\User\Model;

use App\Domains\Role\Model\Role as RoleModel;
use App\Domains\Permissions\Model\Permission as PermissionModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(RoleModel::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Check if user has a specific role
     *
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->roles->contains('name', $roleName);
    }

    /**
     * Check if user has any of given roles
     *
     * @param array|string $roles
     * @return bool
     */
    public function hasAnyRoles($roles): bool
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }

        return (bool) $this->roles->whereIn('name', (array) $roles)->count();
    }

    /**
     * Check if user has all given roles
     *
     * @param array|string $roles
     * @return bool
     */
    public function hasAllRoles($roles): bool
    {
        if (is_string($roles)) {
            return $this->hasRole($roles);
        }

        $roles = (array) $roles;

        return $this->roles->whereIn('name', $roles)->count() === count($roles);
    }

    /**
     * Assign role to user
     *
     * @param RoleModel|string $role
     * @return self
     */
    public function assignRole($role): self
    {
        if (is_string($role)) {
            $role = RoleModel::where('name', $role)->firstOrFail();
        }

        $this->roles()->syncWithoutDetaching([$role->id]);

        return $this;
    }

    /**
     * Sync roles
     *
     * @param array|RoleModel[] $roles
     * @return self
     */
    public function syncRoles(array $roles): self
    {
        $this->roles()->sync($roles);

        return $this;
    }

    /**
     * Remove role from user
     *
     * @param RoleModel|string $role
     * @return self
     */
    public function removeRole($role): self
    {
        if (is_string($role)) {
            $role = RoleModel::where('name', $role)->firstOrFail();
        }

        $this->roles()->detach($role);

        return $this;
    }

    /**
     * Check if user has permission through roles
     *
     * @param string $permission
     * @return bool
     */
    public function hasPermissionThroughRole(string $permission): bool
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }
}