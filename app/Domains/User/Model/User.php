<?php declare(strict_types=1);

namespace App\Domains\User\Model;

use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\User\Model\Builder\User as Builder;
use App\Domains\User\Model\Collection\User as Collection;
use App\Domains\User\Model\Traits\Preferences as PreferencesTrait;
use App\Domains\User\Test\Factory\User as TestFactory;
use App\Domains\UserSession\Model\UserSession as UserSessionModel;

class User extends ModelAbstract implements Authenticatable
{
    use AuthenticatableTrait;
    use HasFactory;
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
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\User\Model\Builder\User
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\User\Test\Factory\User
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language(): BelongsTo
    {
        return $this->belongsTo(LanguageModel::class, LanguageModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(UserSessionModel::class, static::FOREIGN);
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
    public function adminMode(): bool
    {
        return $this->admin && $this->admin_mode;
    }

    /**
     * @return bool
     */
    public function managerMode(): bool
    {
        return $this->manager && $this->manager_mode;
    }
}
