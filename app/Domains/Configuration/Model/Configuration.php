<?php declare(strict_types=1);

namespace App\Domains\Configuration\Model;

use App\Domains\Configuration\Model\Builder\Configuration as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;

class Configuration extends ModelAbstract
{
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
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }
}
