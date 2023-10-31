<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\AlarmNotification\Model\Builder\AlarmNotification as Builder;
use App\Domains\AlarmNotification\Model\Collection\AlarmNotification as Collection;
use App\Domains\AlarmNotification\Test\Factory\AlarmNotification as TestFactory;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\CoreApp\Model\Traits\Gis as GisTrait;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class AlarmNotification extends ModelAbstract
{
    use GisTrait;
    use HasFactory;
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
     * @var array<string, string>
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
     * @param array $models
     *
     * @return \App\Domains\AlarmNotification\Model\Collection\AlarmNotification
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\AlarmNotification\Model\Builder\AlarmNotification
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\AlarmNotification\Test\Factory\AlarmNotification
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
        return $this->belongsTo(AlarmModel::class, AlarmModel::FOREIGN);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(UserModel::class, VehicleModel::class, 'vehicle.id', 'user.id', 'vehicle_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }
}
