<?php declare(strict_types=1);

namespace App\Domains\Server\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domains\Server\Model\Builder\Server as Builder;
use App\Domains\Server\Model\Collection\Server as Collection;
use App\Domains\Server\Test\Factory\Server as TestFactory;
use App\Domains\CoreApp\Model\ModelAbstract;

class Server extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'server';

    /**
     * @const string
     */
    public const TABLE = 'server';

    /**
     * @const string
     */
    public const FOREIGN = 'server_id';

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'debug' => 'boolean',
        'enabled' => 'boolean',
    ];

    /**
     * @param array $models
     *
     * @return \App\Domains\Server\Model\Collection\Server
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \App\Domains\Server\Model\Builder\Server
     */
    public function newEloquentBuilder($query): Builder
    {
        return new Builder($query);
    }

    /**
     * @return \App\Domains\Server\Test\Factory\Server
     */
    protected static function newFactory(): TestFactory
    {
        return TestFactory::new();
    }
}
