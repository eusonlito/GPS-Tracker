<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Alarm\Model\Builder\AlarmDevice as Builder;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\SharedApp\Model\PivotAbstract;

class AlarmDevice extends PivotAbstract
{
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'alarm_device';

    /**
     * @const string
     */
    public const TABLE = 'alarm_device';

    /**
     * @const string
     */
    public const FOREIGN = 'alarm_device_id';

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Alarm\Model\Builder\AlarmDevice
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
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
    }
}
