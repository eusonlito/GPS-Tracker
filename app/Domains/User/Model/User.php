<?php declare(strict_types=1);

namespace App\Domains\User\Model;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\SharedApp\Model\ModelAbstract;
use App\Domains\User\Model\Builder\User as Builder;
use App\Domains\User\Model\Collection\User as Collection;
use App\Domains\User\Model\Traits\Preferences as PreferencesTrait;

class User extends ModelAbstract implements Authenticatable
{
    use AuthenticatableTrait;
    use PreferencesTrait;

    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @const string
     */
    public const TABLE = 'user';

    /**
     * @const string
     */
    public const FOREIGN = 'user_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'preferences' => 'array',
        'telegram' => 'array',
        'enabled' => 'boolean',
    ];

    /**
     * @var array<int, string>
     */
    protected $hidden = ['password'];

    /**
     * @param array $models
     *
     * @return \App\Domains\User\Model\Collection\User
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\User\Model\Builder\User
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(LanguageModel::class, LanguageModel::FOREIGN);
    }
}
