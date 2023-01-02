<?php declare(strict_types=1);

namespace App\Domains\Server\Model;

use App\Domains\Server\Model\Builder\Server as Builder;
use App\Domains\Server\Model\Collection\Server as Collection;
use App\Domains\SharedApp\Model\ModelAbstract;

class Server extends ModelAbstract
{
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Server\Model\Builder\Server
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
