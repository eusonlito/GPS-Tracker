<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\Alarm\Model\AlarmVehicle as AlarmVehicleModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Builder\Vehicle as Builder;
use App\Domains\Vehicle\Model\Collection\Vehicle as Collection;
use App\Domains\Vehicle\Test\Factory\Vehicle as TestFactory;

class Vehicle extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'vehicle';

    /**
     * @const string
     */
    public const TABLE = 'vehicle';

    /**
     * @const string
     */
    public const FOREIGN = 'vehicle_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'timezone_auto' => 'boolean',
        'enabled' => 'boolean',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Vehicle\Model\Builder\Vehicle
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Vehicle\Test\Factory\Vehicle
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function alarmPivot(): HasOne
    {
        return $this->hasOne(AlarmVehicleModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alarms(): BelongsToMany
    {
        return $this->belongsToMany(AlarmModel::class, AlarmVehicleModel::TABLE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alarmsNotifications(): HasMany
    {
        return $this->hasMany(AlarmNotificationModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function devices(): HasMany
    {
        return $this->hasMany(DeviceModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timezone(): BelongsTo
    {
        return $this->belongsTo(TimezoneModel::class, TimezoneModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trips(): HasMany
    {
        return $this->hasMany(TripModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
