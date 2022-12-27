<?php declare(strict_types=1);

namespace App\Domains\Server\Model;

use App\Domains\Server\Model\Builder\Server as Builder;
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Server\Model\Builder\Server
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
