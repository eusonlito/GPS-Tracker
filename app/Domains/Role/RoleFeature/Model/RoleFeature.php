<?php

declare(strict_types=1);

namespace App\Domains\Role\RoleFeature\Model;

use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Role\Model\Role;
use App\Domains\Role\Feature\Model\Feature;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Enterprise\Model\Enterprise as EnterpriseModel;

class RoleFeature extends ModelAbstract
{
    protected $table = 'role_features';

    protected $fillable = ['role_id', 'feature_id'];

    /**
     * Get the role that owns the RoleFeature.
     *
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the feature that owns the RoleFeature.
     *
     * @return BelongsTo
     */
    public function feature(): BelongsTo
    {
        return $this->belongsTo(Feature::class);
    }


    /**
     * Quan hệ: Một RoleFeature thuộc về một Enterprise
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function enterprise(): BelongsTo
    {
        return $this->belongsTo(EnterpriseModel::class, 'enterprise_id');
    }
}
