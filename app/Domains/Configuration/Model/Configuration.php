<?php declare(strict_types=1);

namespace App\Domains\Configuration\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Configuration\Model\Builder\Configuration as Builder;
use App\Domains\Configuration\Model\Collection\Configuration as Collection;
use App\Domains\Configuration\Test\Factory\Configuration as TestFactory;
use App\Domains\CoreApp\Model\ModelAbstract;

class Configuration extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'configuration';

    /**
     * @const string
     */
    public const TABLE = 'configuration';

    /**
     * @const string
     */
    public const FOREIGN = 'configuration_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\Configuration\Model\Collection\Configuration
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Configuration\Model\Builder\Configuration
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Configuration\Test\Factory\Configuration
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }
}
