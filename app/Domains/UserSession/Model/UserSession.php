<?php declare(strict_types=1);

namespace App\Domains\UserSession\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserSession\Model\Builder\UserSession as Builder;
use App\Domains\UserSession\Model\Collection\UserSession as Collection;

class UserSession extends ModelAbstract
{
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
