<?php declare(strict_types=1);

namespace App\Domains\Timezone\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\CoreApp\Model\ModelAbstract;
use App\Domains\CoreApp\Model\Traits\Gis as GisTrait;
use App\Domains\Timezone\Model\Builder\Timezone as Builder;
use App\Domains\Timezone\Model\Collection\Timezone as Collection;
use App\Domains\Timezone\Test\Factory\Timezone as TestFactory;

class Timezone extends ModelAbstract
{
    use GisTrait;
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'timezone';

    /**
     * @const string
     */
    public const TABLE = 'timezone';

    /**
     * @const string
     */
    public const FOREIGN = 'timezone_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'default' => 'boolean',
    ];

    /**
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope('selectIdZone', static fn (Builder $q) => $q->selectOnly('id', 'zone', 'default'));
    }

    /**
     * @param array $models
     *
     * @return \App\Domains\Timezone\Model\Collection\Timezone
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Timezone\Model\Builder\Timezone
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Timezone\Test\Factory\Timezone
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }
}
