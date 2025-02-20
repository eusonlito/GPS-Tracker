<?php

declare(strict_types=1);

namespace App\Domains\Role\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Role\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Domains\Role\RoleFeature\Model\RoleFeature as RoleFeatureModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends ModelAbstract
{
    use HasFactory;
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * @const string
     */
    public const TABLE = 'roles';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'user_roles', 'role_id', 'user_id');
    }

    /**
     * Get the role features for the role.
     *
     * @return HasMany
     */
    public function roleFeature(): HasMany
    {
        return $this->hasMany(RoleFeatureModel::class, 'role_id');
    }
}
