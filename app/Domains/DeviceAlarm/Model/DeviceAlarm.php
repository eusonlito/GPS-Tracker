<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceAlarm\Model\Builder\DeviceAlarm as Builder;
use App\Domains\DeviceAlarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as DeviceAlarmNotificationModel;
use App\Domains\SharedApp\Model\ModelAbstract;

class DeviceAlarm extends ModelAbstract
{
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'device_alarm';

    /**
     * @const string
     */
    public const TABLE = 'device_alarm';

    /**
     * @const string
     */
    public const FOREIGN = 'device_alarm_id';

    /**
     * @var array
     */
    protected $casts = [
        'config' => 'array',
        'telegram' => 'boolean',
        'enabled' => 'boolean',
    ];

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\DeviceAlarm\Model\Builder\DeviceAlarm
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(DeviceAlarmNotificationModel::class, static::FOREIGN);
    }
}
