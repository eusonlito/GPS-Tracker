<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\AlarmNotification\Model\Builder\AlarmNotification as Builder;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\Trip\Model\Trip as TripModel;

class AlarmNotification extends ModelAbstract
{
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'alarm_notification';

    /**
     * @const string
     */
    public const TABLE = 'alarm_notification';

    /**
     * @const string
     */
    public const FOREIGN = 'alarm_notification_id';

    /**
     * @var array
     */
    protected $casts = [
        'config' => 'array',
        'telegram' => 'boolean',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('selectPointAsLatitudeLongitude', static fn (Builder $q) => $q->selectPointAsLatitudeLongitude());
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\AlarmNotification\Model\Builder\AlarmNotification
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
        return $this->belongsTo(AlarmModel::class, AlarmModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN)->withTimeZone();
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
