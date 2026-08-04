<?php declare(strict_types=1);

namespace App\Domains\Expense\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Expense\Model\Builder\Expense as Builder;
use App\Domains\Expense\Model\Collection\Expense as Collection;
use App\Domains\Expense\Test\Factory\Expense as TestFactory;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;
use App\Domains\File\Model\File as FileModel;
use App\Domains\Maintenance\Model\Maintenance as MaintenanceModel;
use App\Domains\Refuel\Model\Refuel as RefuelModel;
use App\Domains\User\Model\User as UserModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Expense extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'expense';

    /**
     * @const string
     */
    public const TABLE = 'expense';

    /**
     * @const string
     */
    public const FOREIGN = 'expense_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\Expense\Model\Collection\Expense
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Expense\Model\Builder\Expense
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Expense\Test\Factory\Expense
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return bool
     */
    public function isRelated(): bool
    {
        return ($this->maintenance_id !== null) || ($this->refuel_id !== null);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ExpenseCategoryModel::class, ExpenseCategoryModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files(): HasMany
    {
        return $this->hasMany(FileModel::class, 'related_id')->byRelatedTable(static::TABLE)->list();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(MaintenanceModel::class, MaintenanceModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refuel(): BelongsTo
    {
        return $this->belongsTo(RefuelModel::class, RefuelModel::FOREIGN);
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
}
