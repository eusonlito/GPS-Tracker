<?php

declare(strict_types=1);

namespace App\Domains\Role\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Role\Model\Traits\TypeFormat;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Domains\Role\RoleFeature\Model\RoleFeature as RoleFeatureModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Enterprise\Model\Enterprise as EnterpriseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Role extends ModelAbstract
{
    use HasFactory;
   // use TypeFormat;

    /**
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Quan hệ: Mỗi Role thuộc về một Enterprise
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(EnterpriseModel::class, 'enterprise_id');
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

    /**
     * Quan hệ: Một Role có nhiều User thông qua `user_roles`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(UserModel::class, 'user_roles', 'role_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Kiểm tra nếu Role thuộc về một Enterprise cụ thể
     *
     * @param int $enterpriseId
     * @return bool
     */
    public function belongsToEnterprise(int $enterpriseId): bool
    {
        return $this->enterprise_id === $enterpriseId;
    }
}
