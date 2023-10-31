<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domains\Alarm\Model\Builder\Alarm as Builder;
use App\Domains\Alarm\Model\Collection\Alarm as Collection;
use App\Domains\Alarm\Model\Traits\TypeFormat as TypeFormatTrait;
use App\Domains\Alarm\Test\Factory\Alarm as TestFactory;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Alarm extends ModelAbstract
{
    use HasFactory;
    use TypeFormatTrait;

    /**
     * @var string
     */
    protected $table = 'alarm';

    /**
     * @const string
     */
    public const TABLE = 'alarm';

    /**
     * @const string
     */
    public const FOREIGN = 'alarm_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'config' => 'array',
        'telegram' => 'boolean',
        'enabled' => 'boolean',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Alarm\Model\Builder\Alarm
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Alarm\Test\Factory\Alarm
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(AlarmNotificationModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vehiclePivot(): HasOne
    {
        return $this->hasOne(AlarmVehicle::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function vehicles(): BelongsToMany
    {
        return $this->belongsToMany(VehicleModel::class, AlarmVehicle::TABLE)->withTimezone();
    }
}
