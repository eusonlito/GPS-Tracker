<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Maintenance\Model\Builder\Maintenance as Builder;
use App\Domains\Maintenance\Model\Collection\Maintenance as Collection;
use App\Domains\Maintenance\Test\Factory\Maintenance as TestFactory;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Maintenance extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'maintenance';

    /**
     * @const string
     */
    public const TABLE = 'maintenance';

    /**
     * @const string
     */
    public const FOREIGN = 'maintenance_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'done' => 'boolean',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Maintenance\Model\Collection\Maintenance
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Maintenance\Model\Builder\Maintenance
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Maintenance\Test\Factory\Maintenance
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(VehicleModel::class, VehicleModel::FOREIGN)->withTimezone();
    }
}
