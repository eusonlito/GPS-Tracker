<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Maintenance\Model\Builder\MaintenanceMaintenanceItem as Builder;
use App\Domains\Maintenance\Model\Collection\MaintenanceMaintenanceItem as Collection;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as MaintenanceItemModel;
use App\Domains\CoreApp\Model\PivotAbstract;

class MaintenanceMaintenanceItem extends PivotAbstract
{
    /**
     * @var string
     */
    protected $table = 'maintenance_maintenance_item';

    /**
     * @const string
     */
    public const TABLE = 'maintenance_maintenance_item';

    /**
     * @const string
     */
    public const FOREIGN = 'maintenance_maintenance_item_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'float',
        'amount_gross' => 'float',
        'amount_net' => 'float',
        'tax_percent' => 'float',
        'subtotal' => 'float',
        'tax_amount' => 'float',
        'total' => 'float',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Maintenance\Model\Collection\MaintenanceMaintenanceItem
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Maintenance\Model\Builder\MaintenanceMaintenanceItem
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(MaintenanceItemModel::class, MaintenanceItemModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class, Maintenance::FOREIGN);
    }
}
