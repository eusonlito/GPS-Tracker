<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;
use App\Domains\Alarm\Model\Builder\AlarmVehicle as Builder;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\SharedApp\Model\PivotAbstract;

class AlarmVehicle extends PivotAbstract
{
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Alarm\Model\Builder\AlarmVehicle
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
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
