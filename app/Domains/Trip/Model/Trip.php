<?php declare(strict_types=1);

namespace App\Domains\Trip\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Builder\Trip as Builder;

class Trip extends ModelAbstract
{
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Trip\Model\Builder\Trip
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
        return $this->belongsTo(DeviceModel::class, DeviceModel::FOREIGN)->withTimeZone();
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
     * @return ?\App\Domains\Trip\Model\Trip
     */
    public function next(): ?Trip
    {
        return self::query()
            ->byDeviceId($this->device->id)
            ->byStartUtcAtNext($this->start_utc_at)
            ->first();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    public function previous(): ?Trip
    {
        return self::query()
            ->byDeviceId($this->device->id)
            ->byStartUtcAtPrevious($this->start_utc_at)
            ->first();
    }

    /**
     * @return void
     */
    public function updateDistanceTime(): void
    {
        static::DB()->statement('
            UPDATE `trip`, (
                WITH `summary` AS (
                    SELECT `trip_id`, ST_Distance(
                        ST_SwapXY(LAG(`point`) OVER (PARTITION BY `trip_id` ORDER BY `date_utc_at` ASC)),
                        ST_SwapXY(`point`)
                    ) AS `distance`
                    FROM `position`
                    WHERE `trip_id` = :trip_id
                    ORDER BY `date_utc_at` ASC
                )
                SELECT `trip_id`, ROUND(COALESCE(SUM(`distance`), 0)) `distance`
                FROM `summary`
                GROUP BY `trip_id`
            ) `summary`
            SET
                `trip`.`distance` = `summary`.`distance`,
                `trip`.`time` = UNIX_TIMESTAMP(`trip`.`end_utc_at`) - UNIX_TIMESTAMP(`trip`.`start_utc_at`)
            WHERE
                `trip`.`id` = `summary`.`trip_id`;
        ', ['trip_id' => $this->id]);
    }
}
