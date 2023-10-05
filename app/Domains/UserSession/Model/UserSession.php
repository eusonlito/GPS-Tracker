<?php declare(strict_types=1);

namespace App\Domains\UserSession\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserSession\Model\Builder\UserSession as Builder;
use App\Domains\UserSession\Model\Collection\UserSession as Collection;
use App\Domains\UserSession\Test\Factory\UserSession as TestFactory;

class UserSession extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'user_session';

    /**
     * @const string
     */
    public const TABLE = 'user_session';

    /**
     * @const string
     */
    public const FOREIGN = 'user_session_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\UserSession\Model\Collection\UserSession
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\UserSession\Model\Builder\UserSession
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\UserSession\Test\Factory\UserSession
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
