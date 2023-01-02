<?php declare(strict_types=1);

namespace App\Domains\IpLock\Model;

use App\Domains\IpLock\Model\Builder\IpLock as Builder;
use App\Domains\IpLock\Model\Collection\IpLock as Collection;
use App\Domains\SharedApp\Model\ModelAbstract;

class IpLock extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'ip_lock';

    /**
     * @const string
     */
    public const TABLE = 'ip_lock';

    /**
     * @const string
     */
    public const FOREIGN = 'ip_lock_id';

    /**
     * @param array $models
     *
     * @return \App\Domains\IpLock\Model\Collection\IpLock
     */
    public function newCollection(array $models = []): Collection
    {
        return new Collection($models);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\IpLock\Model\Builder\IpLock
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
