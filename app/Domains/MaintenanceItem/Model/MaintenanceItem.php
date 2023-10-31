<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Maintenance\Model\Maintenance as MaintenanceModel;
use App\Domains\Maintenance\Model\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemModel;
use App\Domains\MaintenanceItem\Model\Builder\MaintenanceItem as Builder;
use App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem as Collection;
use App\Domains\MaintenanceItem\Test\Factory\MaintenanceItem as TestFactory;
use App\Domains\User\Model\User as UserModel;

class MaintenanceItem extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'maintenance_item';

    /**
     * @const string
     */
    public const TABLE = 'maintenance_item';

    /**
     * @const string
     */
    public const FOREIGN = 'maintenance_item_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\MaintenanceItem\Model\Builder\MaintenanceItem
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\MaintenanceItem\Test\Factory\MaintenanceItem
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function maintenances(): BelongsToMany
    {
        return $this->belongsToMany(MaintenanceModel::class, MaintenanceMaintenanceItemModel::TABLE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maintenancesPivot(): HasMany
    {
        return $this->hasMany(MaintenanceMaintenanceItemModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
