<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\DeviceAlarm\Model\Builder\DeviceAlarmNotification as Builder;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\SharedApp\Model\ModelAbstract;

class DeviceAlarmNotification extends ModelAbstract
{
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
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
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
    }
}
