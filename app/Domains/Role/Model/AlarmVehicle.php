<?php

declare(strict_types=1);

namespace App\Domains\Role\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Role\Model\Builder\RoleVehicle as Builder;
use App\Domains\Role\Model\Collection\RoleVehicle as Collection;
use App\Domains\Role\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\Role\Test\Factory\RoleVehicle as TestFactory;
use App\Domains\CoreApp\Model\PivotAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class RoleVehicle extends PivotAbstract
{
    use HasFactory;
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'Role_vehicle';

    /**
     * @const string
     */
    public const TABLE = 'Role_vehicle';

    /**
     * @const string
     */
    public const FOREIGN = 'Role_vehicle_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\Role\Model\Collection\RoleVehicle
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Role\Model\Builder\RoleVehicle
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Role\Test\Factory\RoleVehicle
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Role(): BelongsTo
    {
        return $this->belongsTo(Role::class, Role::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }
}
