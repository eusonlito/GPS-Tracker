<?php declare(strict_types=1);

namespace App\Domains\Position\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\City\Model\City as CityModel;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\CoreApp\Model\Traits\Gis as GisTrait;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Builder\Position as Builder;
use App\Domains\Position\Model\Collection\Position as Collection;
use App\Domains\Position\Model\Traits\Query as QueryTrait;
use App\Domains\Position\Model\Traits\SelectRaw as SelectRawTrait;
use App\Domains\Position\Test\Factory\Position as TestFactory;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Position extends ModelAbstract
{
    use GisTrait;
    use HasFactory;
    use QueryTrait;
    use SelectRawTrait;

    /**
     * @var string
     */
    protected $table = 'position';

    /**
     * @const string
     */
    public const TABLE = 'position';

    /**
     * @const string
     */
    public const FOREIGN = 'position_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'speed' => 'float',
        'direction' => 'integer',
        'signal' => 'integer',
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
     * @return \App\Domains\Position\Model\Collection\Position
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Position\Model\Builder\Position
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Position\Test\Factory\Position
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(CityModel::class, CityModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN);
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
    public function trip(): BelongsTo
    {
        return $this->belongsTo(TripModel::class, TripModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }

    /**
     * @return string
     */
    public function latitudeLongitudeUrl(): string
    {
        return sprintf('https://maps.google.com/?q=%s,%s', $this->latitude, $this->longitude);
    }

    /**
     * @return string
     */
    public function latitudeLongitudeLink(): string
    {
        return sprintf(
            '<a href="%s" rel="nofollow noopener noreferrer" target="_blank">%.5f,%.5f</a>',
            $this->latitudeLongitudeUrl(),
            $this->latitude,
            $this->longitude,
        );
    }
}
