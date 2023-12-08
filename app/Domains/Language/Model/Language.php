<?php declare(strict_types=1);

namespace App\Domains\Language\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Language\Model\Builder\Language as Builder;
use App\Domains\Language\Model\Collection\Language as Collection;
use App\Domains\Language\Test\Factory\Language as TestFactory;
use App\Domains\CoreApp\Model\ModelAbstract;

class Language extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'language';

    /**
     * @const string
     */
    public const TABLE = 'language';

    /**
     * @const string
     */
    public const FOREIGN = 'language_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'enabled' => 'boolean',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('enabled', static fn (Builder $q) => $q->where(static::TABLE.'.enabled', true));
    }

    /**
     * @param array $models
     *
     * @return \App\Domains\Language\Model\Collection\Language
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Language\Model\Builder\Language
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Language\Test\Factory\Language
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }
}
