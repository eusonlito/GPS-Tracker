<?php

declare(strict_types=1);

namespace App\Domains\Role\Feature\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Role\RoleFeature\Model\RoleFeature as RoleFeatureModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'features';

    /**
     * @const string
     */
    public const TABLE = 'features';

    public function roles(): HasMany
    {
        return $this->hasMany(RoleFeatureModel::class, 'feature_id');
    }
}
