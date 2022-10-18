<?php declare(strict_types=1);

namespace App\Domains\IpLock\Model;

use App\Domains\IpLock\Model\Builder\IpLock as Builder;
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }
}
