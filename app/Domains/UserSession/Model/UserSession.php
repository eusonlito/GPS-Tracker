<?php declare(strict_types=1);

namespace App\Domains\UserSession\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserSession\Model\Builder\UserSession as Builder;

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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }
}
