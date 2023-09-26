<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Alarm\Model\Builder\AlarmVehicle as Builder;
use App\Domains\Alarm\Model\Collection\AlarmVehicle as Collection;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\Alarm\Test\Factory\AlarmVehicle as TestFactory;
use App\Domains\CoreApp\Model\PivotAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class AlarmVehicle extends PivotAbstract
{
    use HasFactory;
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'alarm_vehicle';

    /**
     * @const string
     */
    public const TABLE = 'alarm_vehicle';

    /**
     * @const string
     */
    public const FOREIGN = 'alarm_vehicle_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\Alarm\Model\Collection\AlarmVehicle
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Alarm\Model\Builder\AlarmVehicle
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Alarm\Test\Factory\AlarmVehicle
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alarm(): BelongsTo
    {
        return $this->belongsTo(Alarm::class, Alarm::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }
}
