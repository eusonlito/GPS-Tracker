<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceAlarm\Model\Builder\DeviceAlarm as Builder;
use App\Domains\DeviceAlarm\Service\Type\Manager as TypeManager;
use App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract as TypeFormatAbstract;
use App\Domains\SharedApp\Model\ModelAbstract;

class DeviceAlarm extends ModelAbstract
{
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
        'enabled' => 'boolean',
    ];

    /**
     * @var \App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $typeFormat;

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
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(DeviceAlarmNotification::class, static::FOREIGN);
    }

    /**
     * @return \App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract
     */
    public function type(): TypeFormatAbstract
    {
        return $this->typeFormat ??= TypeManager::new()->factory($this->type, $this->config);
    }
}
