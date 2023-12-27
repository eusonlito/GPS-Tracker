<?php declare(strict_types=1);

namespace App\Domains\Trip\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Builder\Trip as Builder;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Traits\Query as QueryTrait;
use App\Domains\Trip\Model\Traits\Statement as StatementTrait;
use App\Domains\Trip\Test\Factory\Trip as TestFactory;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Trip extends ModelAbstract
{
    use HasFactory;
    use QueryTrait;
    use StatementTrait;

    /**
     * @var string
     */
    protected $table = 'trip';

    /**
     * @const string
     */
    public const TABLE = 'trip';

    /**
     * @const string
     */
    public const FOREIGN = 'trip_id';

    /**
     * @const string
     */
    protected const DATE_REGEXP = '[0-9]{4}\-[0-9]{2}\-[0-9]{2}\s[0-9]{2}:[0-9]{2}:[0-9]{2}';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'stats' => 'array',
        'shared' => 'boolean',
        'shared_public' => 'boolean',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Trip\Model\Builder\Trip
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Trip\Test\Factory\Trip
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN)->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function positions(): HasMany
    {
        return $this->hasMany(PositionModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timezone(): BelongsTo
    {
        return $this->belongsTo(TimezoneModel::class, TimezoneModel::FOREIGN);
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
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }

    /**
     * @return bool
     */
    public function nameIsDefault(): bool
    {
        return (bool)preg_match('/^'.static::DATE_REGEXP.'(\s\-\s'.static::DATE_REGEXP.')?$/', $this->getOriginal('name') ?: $this->name);
    }

    /**
     * @return string
     */
    public function nameFromDates(): string
    {
        return implode(' - ', array_filter(array_unique([$this->start_at, $this->end_at])));
    }

    /**
     * @return bool
     */
    public function finished(): bool
    {
        $wait = app('configuration')->int('trip_wait_minutes');
        $time = strtotime($this->end_utc_at);

        return $wait >= ((time() - $time) / 60);
    }
}
