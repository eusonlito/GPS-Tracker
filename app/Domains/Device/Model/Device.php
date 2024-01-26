<?php declare(strict_types=1);

namespace App\Domains\Device\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Device\Model\Builder\Device as Builder;
use App\Domains\Device\Model\Collection\Device as Collection;
use App\Domains\Device\Test\Factory\Device as TestFactory;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Device extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'device';

    /**
     * @const string
     */
    public const TABLE = 'device';

    /**
     * @const string
     */
    public const FOREIGN = 'device_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
        'shared' => 'boolean',
        'shared_public' => 'boolean',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Device\Model\Collection\Device
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Device\Model\Builder\Device
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Device\Test\Factory\Device
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(PositionModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function positionLast(): HasOne
    {
        return $this->hasOne(PositionModel::class, static::FOREIGN)
            ->ofMany(['date_utc_at' => 'MAX'], fn ($q) => $q->withoutGlobalScope('selectPointAsLatitudeLongitude'))
            ->selectOnlyLatitudeLongitude();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(DeviceMessageModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tripLast(): HasOne
    {
        return $this->hasOne(TripModel::class, static::FOREIGN)
            ->ofMany(['end_utc_at' => 'MAX']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tripLastShared(): HasOne
    {
        return $this->hasOne(TripModel::class, static::FOREIGN)
            ->ofMany(['endutc_at' => 'MAX'], fn ($q) => $q->whereShared());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tripLastSharedPublic(): HasOne
    {
        return $this->hasOne(TripModel::class, static::FOREIGN)
            ->ofMany(['end_utc_at' => 'MAX'], fn ($q) => $q->whereSharedPublic());
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN);
    }
}
