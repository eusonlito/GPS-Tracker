<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Expense\Model\Expense as ExpenseModel;
use App\Domains\ExpenseCategory\Model\Builder\ExpenseCategory as Builder;
use App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory as Collection;
use App\Domains\ExpenseCategory\Test\Factory\ExpenseCategory as TestFactory;
use App\Domains\User\Model\User as UserModel;

class ExpenseCategory extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'expense_category';

    /**
     * @const string
     */
    public const TABLE = 'expense_category';

    /**
     * @const string
     */
    public const FOREIGN = 'expense_category_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\ExpenseCategory\Model\Builder\ExpenseCategory
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\ExpenseCategory\Test\Factory\ExpenseCategory
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return bool
     */
    public function isGlobal(): bool
    {
        return $this->user_id === null;
    }

    /**
     * @return bool
     */
    public function isSystem(): bool
    {
        return $this->code !== null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(ExpenseModel::class, static::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
