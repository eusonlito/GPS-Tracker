<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\DeviceAlarm\Model\Builder\DeviceAlarmNotification as Builder;
use App\Domains\DeviceAlarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\SharedApp\Model\ModelAbstract;

class DeviceAlarmNotification extends ModelAbstract
{
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'device_alarm_notification';

    /**
     * @const string
     */
    public const TABLE = 'device_alarm_notification';

    /**
     * @const string
     */
    public const FOREIGN = 'device_alarm_notification_id';

    /**
     * @var array
     */
    protected $casts = [
        'config' => 'array',
    ];

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\DeviceAlarm\Model\Builder\DeviceAlarmNotification
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
        return $this->belongsTo(DeviceAlarm::class, DeviceAlarm::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(PositionModel::class, PositionModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(TripModel::class, TripModel::FOREIGN);
    }
}
